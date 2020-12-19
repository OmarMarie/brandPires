<?php

namespace App\Http\Controllers\Api;

use App\Models\PlayerTankAction;
use App\Models\Tanks;
use App\Traits\ApiResponser;
use App\Traits\MessageLanguage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TankController extends Controller
{
    use ApiResponser ,MessageLanguage;

    public function tanks(Request $request)
    {
        $this->checkLang($request);
        $playerId = $request->user()->id;
        $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $playerId)->first();
        $tanks = Tanks::where('id', '>=', $tankDetails->tank_id)->get();
        if (count($tanks) > 0) {
            foreach ($tanks as $tank)
            {
                $tank['tank_icon'] = env('APP_URL').'/images/tank/'.$tank['tank_icon'];
            }
            return $this->apiResponse($tanks, null, 200, 0);
        } else {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Tanks not found!';
                    break;
                case 'ar':
                    $message ="لم يتم العثور على الخزانات!";
                    break;
                default:
                    $message = 'Tanks not found!';
                    break;
            }
            return $this->apiResponse(null,$message , 200, 0);
        }

    }

    public function updateTank(Request $request)
    {
        $this->checkLang($request);
        try {
            $tankToName = Tanks::findOrFail($request->tank_id);

        } catch (ModelNotFoundException $exception) {
            return $this->apiResponse(null, 'Tank not found!', 200, 0);
        }

        $playerTankId = PlayerTankAction::where('player_id', $request->player_id)->first();

        if ($request->tank_id > $playerTankId->tank_id) {
            PlayerTankAction::where('player_id', $request->player_id)->update([
                'tank_id' => $request->tank_id,
                'updated_at' => now()
            ]);
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Upgraded to ' ;
                    $successfully=' Successfully';
                    break;
                case 'ar':
                    $message ="ترقية إلى";
                    $successfully=' بنجاح';
                    break;
                default:
                    $message = 'Upgraded to ' ;
                    $successfully=' Successfully';
                    break;
            }
            return $this->apiResponse(null,$message . $tankToName['name'] .$successfully, 200, 1);
        } else {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Failed to upgrade to ';
                    break;
                case 'ar':
                    $message = "فشل الترقية إلى";
                    break;
                default:
                    $message = 'Failed to upgrade to ';
                    break;
            }
            return $this->apiResponse(null,$message  . $tankToName['name'] . '', 200, 1);
        }
    }

    public function infoTank(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'tank_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }
        $tankInfo = Tanks::where('id',  $request->tank_id)->first();
        $tankInfo['tank_icon'] = env('APP_URL').'/images/tank/'.$tankInfo['tank_icon'];

        return $this->apiResponse($tankInfo, null, 200, 1);
    }
}
