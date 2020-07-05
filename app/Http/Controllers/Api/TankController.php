<?php

namespace App\Http\Controllers\Api;

use App\Models\PlayerTankAction;
use App\Models\Tanks;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TankController extends Controller
{
    use ApiResponser;
    public function tanks($id)
    {
        $tanks = Tanks::where('id', '>=', $id)->get();
        return $tanks;
    }

    public function updateTank(Request $request)
    {
        try{
            $tankToName = Tanks::findOrFail($request->tank_id);

        } catch (ModelNotFoundException $exception)
        {
            return $this->apiResponse(null, 'Tank not found!', 200, 0);
        }

        $playerTankId = PlayerTankAction::where('player_id', $request->player_id)->first();

        if ($request->tank_id > $playerTankId->tank_id)
        {
          PlayerTankAction::where('player_id', $request->player_id)->update([
           'tank_id' => $request->tank_id,
            'updated_at' => now()
        ]);
            return $this->apiResponse(null, 'Upgraded to '.$tankToName['name'].' successfully', 200, 1);
        } else {
            return $this->apiResponse(null, 'Failed to upgrade to '.$tankToName['name'].'', 200, 1);
        }
    }

    public function infoTank($id)
    {
        $tankInfo = Tanks::where('id', $id)->first();

        return $this->apiResponse($tankInfo, null, 200, 1);
    }
}
