<?php

namespace App\Http\Controllers\Web;

use App\Models\Levels;
use App\Models\Player;
use App\Models\PlayerBubbles;
use App\Models\PlayerTankAction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('brandpriers.player.index');

    }

    public function playersDatable(Request $request)
    {


        if ($request->ajax()) {
            $data = Player::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('level', function ($data) {
                    $levelDetails = Levels::where('id', $data->level_id)->first();
                    if ($levelDetails != null)
                        return $levelDetails->level_name;
                    else
                        return null;
                })
                ->editColumn('lvl_pts', function ($data) {
                    if ($data->lvl_pts == '')
                        return 0;
                    else
                        return $data->lvl_pts;
                })
                ->addColumn('level_points', function ($data) {
                    $levelPts = Player::find($data->id)->level;
                    if ($levelPts != null)
                        return $levelPts->to_pts;
                    else
                        return null;
                })
                ->addColumn('tank', function ($data) {
                    $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $data->id)->first();
                    return $tankDetails->tanks->name;
                })
                ->addColumn('tank_points', function ($data) {
                    $numberOfTankBubbles = PlayerBubbles::where('player_id', $data->id)->where('status', 1)->count();
                    if ($numberOfTankBubbles == '')
                        return 0;
                    else
                        return $numberOfTankBubbles;
                })
                ->addColumn('tank_size', function ($data) {
                    $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $data->id)->first();
                    return $tankDetails->tanks->size;
                })
                ->addColumn('extraTank', function ($data) {
                    $extraTank = 0;
                    $levelDetails = Levels::where('id', $data->level_id)->first(['extra', 'duration']);
                    if ($levelDetails == '')
                        return 0;
                    else {
                        $extraLiveTime = $levelDetails->duration;
                        $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $data->id)->first();
                        if ($data->level_updated_at != null) {
                            $expired_at = date('Y-m-d H:i:s', strtotime('+' . $extraLiveTime . ' hours', strtotime($data->level_updated_at)));
                            if (now() < $expired_at) {
                                $extraTank = ($tankDetails['tanks']->size * ($levelDetails->extra / 100));
                            }
                        }
                        return $extraTank;
                    }
                })
                ->make(true);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brandpriers.player.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:players',
            'email' => 'required|string|email|unique:players',
            'phone_number' => 'required|unique:players',
            'birth_day' => 'required',
            'password' => 'required|string|min:8|max:20'
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $birth_day = Carbon::parse($request->birth_day)->format('Y-m-d');

        $player = new Player([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birth_day' => $birth_day,
            'img' => 'default.jpg',
            'password' => bcrypt($request->password),
            'level_id' => 1,
        ]);
        $player->save();

        PlayerTankAction::create([
            'tank_id' => 1,
            'player_id' => $player->id,
            'action' => 0,
            'status' => 1,
            'tank_pts' => 0
        ]);
        return response()->json(['message' => 'Add Player successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($local, Player $player)
    {
        return view('brandpriers.player.create', compact('player'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request, Player $player)
    {
        $validations = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:players,email,' . $player->id,
            'phone_number' => 'required|unique:players,phone_number,' . $player->id,
            'birth_day' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }
        $birth_day = Carbon::parse($request->birth_day)->format('Y-m-d');

        $player->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birth_day' => $birth_day,
        ]);
        return response()->json(['message' => 'Updated Player successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local, Player $player)
    {
        $player->delete();
    }


    public function addPoints($local, $player_id)
    {
        $player = Player::where('id', $player_id)->first();
        return view('brandpriers.player.pointCreate', compact('player'));
    }

    public function pointsUpdate($local, Request $request)
    {
        $validations = Validator::make($request->all(), [
            'point_add' => 'required|numeric'
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }
        $player = Player::where('id', $request->player_id)->first();

        $userLvlPts = $player->lvl_pts;

        $calcLvlPts = $userLvlPts + $request->point_add;

        $levelDetails = Levels::where('id', $player->level_id)->first();
        $levelIdNew = Levels::where('to_pts', '>=', $calcLvlPts)
            ->where('from_pts', '<=', $calcLvlPts)
            ->value('id');
        if ($levelIdNew == null) {
            return response()->json(['message' => 'Not Found Upgrade level', 'status' => 423]);
        }

        if ($calcLvlPts > $levelDetails->to_pts) {
            $player->update([
                'level_id' => $levelIdNew,
                'lvl_pts' => $calcLvlPts,
                'level_updated_at' => now()
            ]);
        } else {
            $player->update([
                'lvl_pts' => $calcLvlPts
            ]);
        }

        return response()->json(['message' => 'Add Player Points successfully', 'status' => 200]);
    }

    public function replaceBubbles($local,$player_id ,Request $request)
    {
        $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $player_id)->first();
        $tankBubbles = PlayerBubbles::where('player_id', $player_id)->where('status', 1)->get();

        $numberOfTankBubbles= count($tankBubbles);

        if ( $numberOfTankBubbles >=  $tankDetails->tanks->size )
        {
            foreach ( $tankBubbles as $bubble)
            {
                $bubble->update([
                    'status' => 2,
                    'replaced_by' => auth()->id(),
                ]);
            }

            return response()->json(['message' => 'Replaced Bubbles successfully', 'status' => 200]);
        }
        return response()->json(['message' => 'Please Confirm the Number Bubbles', 'status' => 200]);
    }
}
