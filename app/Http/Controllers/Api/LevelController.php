<?php

namespace App\Http\Controllers\Api;


use App\Models\Levels;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    use ApiResponser;

    public function levels()
    {
        $levels = Levels::all();

        if (count($levels) > 0) {
            foreach ($levels as $level) {
                $level['level_icon'] = env('APP_URL') . '/images/level/' . $level['level_icon'];
            }
            return $this->apiResponse($levels, null, 200, 0);
        } else {
            return $this->apiResponse(null, 'Levels not found!', 200, 0);
        }

    }

    public function infoLevel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }
        $levelInfo = Levels::where('id',  $request->level_id)->first();
        $levelInfo['level_icon'] = env('APP_URL').'/images/level/'.$levelInfo['level_icon'];

        return $this->apiResponse($levelInfo, null, 200, 1);
    }
}
