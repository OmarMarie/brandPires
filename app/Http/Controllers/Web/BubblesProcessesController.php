<?php

namespace App\Http\Controllers\Web;


use App\Models\Brand;
use App\Models\BubblesProcess;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BubblesProcessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('brandpriers.bubblesProcesses.index');
    }

    public function bubblesProcessesDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = BubblesProcess::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('campaign_id', function ($data) {
                    $campaignName=Campaign::where('id',$data->campaign_id)->value('name');
                    if($campaignName == null)
                        return null;
                    else
                        return $campaignName;

                })
                ->addColumn('brand_name', function ($data) {
                    $brand_id=Campaign::where('id',$data->campaign_id)->value('brand_id');
                    $brindName=Brand::where('id',$brand_id)->value('brand_name');
                    if($brindName == null)
                        return null;
                    else
                        return $brindName;

                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d/m/Y - g:i A');
                })
                ->make(true);
        }

    }

}
