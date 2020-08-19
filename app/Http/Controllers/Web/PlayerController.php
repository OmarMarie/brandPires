<?php

namespace App\Http\Controllers\Web;

use App\Models\Levels;
use App\Models\Player;
use App\Models\PlayerBubbles;
use App\Models\PlayerTankAction;
use Illuminate\Http\Request;
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
                    return $levelDetails->level_name;
                })
                ->editColumn('lvl_pts', function ($data) {
                    if ($data->lvl_pts == '')
                        return 0;
                    else
                        return $data->lvl_pts;
                })
                ->addColumn('level_points', function ($data) {
                    $levelPts = Player::find($data->id)->level;
                    return $levelPts->to_pts;
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
                    $extraLiveTime = $levelDetails->duration;
                    $tankDetails = PlayerTankAction::with('tanks')->where('player_id', $data->id)->first();
                    if ($data->level_updated_at != null) {
                        $expired_at = date('Y-m-d H:i:s', strtotime('+' . $extraLiveTime . ' hours', strtotime($data->level_updated_at)));
                        if (now() < $expired_at) {
                            $extraTank = ($tankDetails['tanks']->size * ($levelDetails->extra / 100));
                        }
                    }
                    return $extraTank;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
