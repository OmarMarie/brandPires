<?php

namespace App\Http\Controllers\Web;


use App\Models\Brand;
use App\Models\Bulks;
use App\Models\Campaign;
use App\Models\CompanyPackageLogs;
use App\Models\Employee;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($locale, $brand_id,$package_logs_id)
    {

        $brandName = Brand::where('id', $brand_id)->value('brand_name');
        $package_id = CompanyPackageLogs::where('id', $package_logs_id)->value('package_id');
        $package = Package::where('id', $package_id)->first();
        return view('brandpriers.campaigns.index', compact('brand_id', 'brandName','package_logs_id','package'));
    }

    public function campaignsDatable(Request $request)
    {
        if ($request->ajax()) {
            $data=Campaign::Where('brand_id', $request->brand_id)
                ->Where('package_logs_id', $request->package_id)
                ->get();
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
    public function create($local,$brand_id,$package_logs_id)
    {
        $bulks = Bulks::all();
        $employees = Employee::all();
        return view('brandpriers.campaigns.create',compact('bulks','employees','brand_id','package_logs_id'));
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
            'name' => 'required',
            'mark_pts' => 'required',
            'gifts_numbers' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'date' => 'required',
            'employee_id' => 'required',
            'bulk_id' => 'required',
            'available' => 'required',
            'speed' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Campaign::create([
            'name' => $request->name,
            'mark_pts' => $request->mark_pts,
            'gifts_numbers' => $request->gifts_numbers,
            'from_time' => date("H:i:s", strtotime($request->from_time)),
            'to_time' => date("H:i:s", strtotime($request->to_time)),
            'employee_id' => $request->employee_id,
            'date' => Carbon::parse($request->date)->format('Y/m/d'),
            'bulk_id' => $request->bulk_id,
            'available' => $request->available,
            'speed' => $request->speed,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'brand_id' => $request->brand_id,
        ]);

        return response()->json(['message' => 'Added Campaign successfully', 'status' => 200]);
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
    public function edit($local,Campaign $campaign)
    {
        $bulks = Bulks::all();
        $employees = Employee::all();
        return view('brandpriers.campaigns.create',compact('bulks','employees','campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local,Request $request, Campaign $campaign)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'mark_pts' => 'required',
            'gifts_numbers' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'date' => 'required',
            'employee_id' => 'required',
            'bulk_id' => 'required',
            'available' => 'required',
            'speed' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $campaign->update([
            'name' => $request->name,
            'mark_pts' => $request->mark_pts,
            'gifts_numbers' => $request->gifts_numbers,
            'from_time' => date("H:i:s", strtotime($request->from_time)),
            'to_time' => date("H:i:s", strtotime($request->to_time)),
            'employee_id' => $request->employee_id,
            'date' => Carbon::parse($request->date)->format('Y/m/d'),
            'bulk_id' => $request->bulk_id,
            'available' => $request->available,
            'speed' => $request->speed,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        return response()->json(['message' => 'Update Campaign successfully', 'status' => 200]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local,Campaign $campaign)
    {
        $campaign->delete();
    }
}
