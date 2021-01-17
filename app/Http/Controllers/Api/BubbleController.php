<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Country;
use App\Models\Gift;
use App\Models\GiftAction;
use App\Traits\ApiResponser;
use App\Traits\MessageLanguage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class BubbleController extends Controller
{
    use ApiResponser, MessageLanguage;

    public function gifts(Request $request)
    {
        $this->checkLang($request);
        $playerId = $request->user()->id;
        $gifts = GiftAction::where('player_id', $playerId)->where('action', 1)
            ->with('gift:id,bubble_id,name,code_number,gift_from,country_id,city_id,center,date_of_coupon,img')
            ->get();
        if (count($gifts) > 0) {
            $giftsPlayer = [];
            foreach ($gifts as $gift) {
                $gift->gift['country_id'] = Country::where('id', $gift->gift['country_id'])->value('name');
                $gift->gift['city_id'] = City::where('id', $gift->gift['city_id'])->value('name');
                $gift->gift['date_of_coupon'] = Carbon::parse($gift->gift['date_of_coupon'])->format('d-m-Y');
                $gift->gift['img'] = env('APP_URL') . '/images/gift/' . $gift->gift['img'];

                array_push($giftsPlayer, $gift->gift);
            }

            return $this->apiResponse($giftsPlayer, null, 200, 1);
        }
        switch ($request->header('lang')) {
            case 'en':
                $message = 'There are no gifts';
                break;
            case 'ar':
                $message = "لا توجد هدايا";
                break;
            default:
                $message = 'There are no gifts';
                break;
        }
        return $this->apiResponse(null, $message, 200, 0);
    }


    public function giftDetails(Request $request)
    {
        $this->checkLang($request);
        $playerId = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'gift_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        $gifts = GiftAction::where('player_id', $playerId)->where('action', 1)->with('gift:id,bubble_id')->get();
        $gift = $gifts->pluck('gift');
        $id_gift = $gift->pluck('id')->toArray();
        if ((in_array($request->gift_id, $id_gift))) {
            $gift = Gift::findOrFail($request->gift_id);
            $gift['img'] = env('APP_URL').'/images/gift/'.$gift['img'];
        } else {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Gift not found';
                    break;
                case 'ar':
                    $message = "لم يتم العثور على الهدية";
                    break;
                default:
                    $message = 'Gift not found';
                    break;
            }
            return $this->apiResponse(null, $message, 200, 0);
        }
        return $this->apiResponse($gift, null, 200, 1);
    }
}
