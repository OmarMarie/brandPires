<?php

namespace App\Http\Controllers\Api;

use App\Models\Gift;
use App\Models\GiftAction;
use App\Traits\ApiResponser;
use App\Traits\MessageLanguage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BubbleController extends Controller
{
    use ApiResponser,MessageLanguage;

    public function gifts($player_id,Request $request)
    {
        $this->checkLang($request);
        $gifts = GiftAction::where('player_id', $player_id)->where('action', 1)->get();

        return $this->apiResponse($gifts, null, 200, 1);
    }

    public function giftDetails(Request $request)
    {
        $this->checkLang($request);
       try{
           $gift = Gift::findOrFail($request->gift_id);
       } catch (ModelNotFoundException $exception)
       {
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
           return $this->apiResponse(null,$message , 200, 0);
       }
       return $this->apiResponse($gift, null, 200, 1);
    }
}
