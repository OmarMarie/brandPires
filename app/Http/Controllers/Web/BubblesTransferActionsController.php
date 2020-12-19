<?php

namespace App\Http\Controllers\Web;

use App\Models\BubblesTransferAction;
use App\Models\Player;
use App\Models\Tanks;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BubblesTransferActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('brandpriers.bubblesTransferActions.index');
    }


    public function bubblesTransferActionsDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = BubblesTransferAction::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('player_tank_id', function ($data) {
                    $playerTankName = Tanks::where('id', $data->player_tank_id)->value('name');
                    if ($playerTankName == null)
                        return null;
                    else
                        return $playerTankName;

                })
                ->editColumn('player_id', function ($data) {
                    $first_name = Player::where('id', $data->player_id)->value('first_name');
                    $last_name = Player::where('id', $data->player_id)->value('last_name');
                    $playeName = $first_name .' '. $last_name;
                    if ($playeName == null)
                        return null;
                    else
                        return $playeName;

                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d/m/Y - g:i A');
                })
                ->make(true);
        }
    }


}
