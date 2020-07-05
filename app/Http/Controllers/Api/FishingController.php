<?php

namespace App\Http\Controllers\Api;

use App\Models\Bubbles;
use App\Models\Campaign;
use App\Models\GiftAction;
use App\Models\Levels;
use App\Models\Player;
use App\Models\PlayerBubbles;
use App\Models\PlayerTankAction;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FishingController extends Controller
{
    use ApiResponser;

    public function getBubblesInLocation(Request $request)
    {
        $campaigns = Campaign::where('lat', $request->lat)->where('lng', $request->lng)->pluck('id');
        $bubbles = Bubbles::whereIn('campaign_id', $campaigns)->get();
        return $this->apiResponse($bubbles, null, 200, 1);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Variable $numberOfTankBubbles contain all captured bubbles the player has.
     * If number of tank bubbles grater than the tank capacity then player wont able to capture anymore until the tank got upgraded.
     * Else ->
     */

    public function hook($id)
    {
        $levelDetails = Levels::where('id', auth()->user()->level_id)->first(['extra', 'to_pts', 'speed', 'duration']);
        $tankDetails = PlayerTankAction::with('tanks')->where('player_id', auth()->user()->id)->first();

        $extraLiveTime = $levelDetails->duration;
        // updated at -> date + 48 && if equal now() return the normal size else return size with extra
        $tankCapacity = $tankDetails['tanks']->size;

        if (auth()->user()->level_updated_at != null) {
            $expiredAt = date('Y-m-d H:i:s', strtotime('+' . $extraLiveTime . ' hours', strtotime(auth()->user()->level_updated_at)));
            if (now() < $expiredAt) {
                $tankCapacity = ($tankDetails['tanks']->size * ($levelDetails->extra / 100)) + $tankDetails['tanks']->size;
            }
        }

        $numberOfTankBubbles = PlayerBubbles::where('player_id', auth()->user()->id)->where('status', 1)->count();

        if ($numberOfTankBubbles > $tankCapacity) {
            return $this->apiResponse(null, 'You cannot hook new bubbles until replace/upgrade your tank', 200, 0);
        }

        try {
            $bubble = Bubbles::findOrFail($id);
            $bubbleType = $bubble->bubble_type;

        } catch (ModelNotFoundException $exception) {
            return $this->apiResponse(null, 'Bubble not found', 404, 0);
        }
        $bubbleAvailable = Bubbles::where('id', $id)->first();
        if ($bubbleAvailable->available == 0) {
            return $this->apiResponse(null, 'Bubble not available', 404, 0);
        } else {

            Bubbles::where('id', $id)->update(['available' => 0]);
            PlayerBubbles::create([
                'player_id' => auth()->user()->id,
                'bubble_id' => $id
            ]);

            if ($bubbleType == 1) {
                GiftAction::create([
                    'player_id' => auth()->user()->id,
                    'bubble_id' => $id
                ]);
            }

            //$levelIncreasedValue = 100; // Todo: change the value of increase level / X -> more details is needed

            $userLvlPts = auth()->user()->lvl_pts;

            $bubblePoints = Bubbles::where('id', $id)->value('bubble_weight');

            $calcLvlPts = ($bubblePoints * $levelDetails->speed) + $userLvlPts;

            $levelId = auth()->user()->level_id;

            $levelIdNew = ++$levelId;

            $lastLevelId = Levels::orderBy('id', 'DESC')->value('id');

            if ($calcLvlPts > $levelDetails->to_pts) {
                if ($levelIdNew > $lastLevelId) {
                    return $this->apiResponse(null, 'Unable to upgrade to next level', 200, 1);
                } else {
                    Player::where('id', auth()->user()->id)->update([
                        'level_id' => $levelIdNew,
                        'lvl_pts' => $calcLvlPts,
                        'level_updated_at' => now()
                    ]);
                }

            } else {
                Player::where('id', auth()->user()->id)->update([
                    'lvl_pts' => $calcLvlPts
                ]);
            }

        }

        return $this->apiResponse(null, 'Player hooked bubble number ' . $id . ' successfully', 200, 1);
    }

    public function test()
    {
        $playersBubbles = PlayerBubbles::with('bubbles:id,duration,available,campaign_id,bubble_type')->get();

        foreach ($playersBubbles as $playersBubble) {
            $expireDate = date('Y-m-d H:i:s', strtotime('+'.$playersBubble->bubbles->duration.' hours', strtotime($playersBubble->created_at)));


            if (now() > $expireDate)
            {
                $campaignAvailable = Campaign::where('id', $playersBubble->bubbles->campaign_id)->value('available');
                if ($campaignAvailable == 1){// if campaign available
                    Bubbles::where('id', $playersBubble->bubbles->id)->update([
                       'available' => 1
                    ]);
                } else {
                    Bubbles::where('id', $playersBubble->bubbles->id)->update([
                        'available' => 0,
                        'status' => 2
                    ]);
                }

                if ($playersBubble->bubbles->bubble_type == 1){
                    GiftAction::where('player_id', $playersBubble->player_id)->where('bubble_id', $playersBubble->bubble_id)->update([
                        'action' => 0
                    ]);
                }

                PlayerBubbles::where('id', $playersBubble->id)->update([
                   'status' => 2
                ]);
            }
        }

    }
}
