<?php

namespace App\Http\Controllers\Web;

use App\Models\Brand;
use App\Models\BrandCampaign;
use App\Models\Campaign;
use App\Models\CompanyPackageLogs;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogCampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('brandpriers.logCampaingns.index');
    }

    public function logCampaignsDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = Campaign::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('brand_id', function ($data) {
                    $Name = Brand::where('id', $data->brand_id)->value('brand_name');
                    if ($Name == null)
                        return null;
                    else
                        return $Name;

                })
                ->editColumn('added_by', function ($data) {
                    $Name = User::where('id', $data->added_by)->value('name');
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
