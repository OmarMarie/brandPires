<?php

namespace App\Http\Controllers\Api;

use App\Models\Gift;
use App\Models\GiftAction;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BubbleController extends Controller
{
    use ApiResponser;

    public function gifts($player_id)
    {
        $gifts = GiftAction::where('player_id', $player_id)->where('action', 1)->get();

        return $this->apiResponse($gifts, null, 200, 1);
    }

    public function giftDetails($id)
    {
       try{
           $gift = Gift::findOrFail($id);
       } catch (ModelNotFoundException $exception)
       {
           return $this->apiResponse(null, 'Gift not found', 200, 0);
       }
       return $this->apiResponse($gift, null, 200, 1);
    }
}
