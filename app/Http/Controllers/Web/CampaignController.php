<?php

namespace App\Http\Controllers\Web;


use App\Brand;
use App\Models\Campaign;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2($locale, $brand_id)
    {
        $brandName = Brand::where('id', $brand_id)->value('brand_name');
        return view('brandpriers.campaigns.index', compact('brand_id', 'brandName'));
    }

    public function campaignsDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = Campaign::Where('brand_id', $request->brand_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('available', function ($data) {
                    return $data->available == 0 ? 'False' : 'True';
                })
                ->editColumn('employee_id', function ($data) {
                    $employee = Employee::where('id', $data->employee_id)->value('name');
                    if ($employee != null)
                        return $employee;
                    else
                        return 'Not Found';
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