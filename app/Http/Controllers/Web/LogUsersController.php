<?php

namespace App\Http\Controllers\Web;

use App\Models\LogUser;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brandpriers.logUsers.index');
    }

    public function logUsersDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = LogUser::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function ($data) {
                    $Name = User::where('id', $data->user_id)->value('name');
                    if ($Name == null)
                        return null;
                    else
                        return $Name;

                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d/m/Y - g:i A');
                })
                ->make(true);

        }
    }
}
