<?php

namespace App\Http\Controllers\Api;

use App\Models\PlayerTankAction;
use App\Models\Tanks;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TankController extends Controller
{
    use ApiResponser;

    public function tanks(Request $request)
    {
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
        $tanks = Tanks::where('id', '>=', $request->tank_id)->get();

        if (count($tanks) > 0) {
            foreach ($tanks as $tank)
            {
                $tank['tank_icon'] = env('APP_URL').'/images/tank/'.$tank['tank_icon'];
            }
            return $this->apiResponse($tanks, null, 200, 0);
        } else {
            return $this->apiResponse(null, 'Tanks not found!', 200, 0);
        }

    }

    public function updateTank(Request $request)
    {
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
            return $this->apiResponse(null, 'Upgraded to ' . $tankToName['name'] . ' successfully', 200, 1);
        } else {
            return $this->apiResponse(null, 'Failed to upgrade to ' . $tankToName['name'] . '', 200, 1);
        }
    }

    public function infoTank(Request $request)
    {
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
