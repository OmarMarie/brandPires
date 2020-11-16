<?php

namespace App\Http\Controllers\Web;


use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CompanyPackage;
use App\Models\CompanyPackageLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CompanyPackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brandpriers.companyPackages.index');
    }

    public function companyPackagesDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = CompanyPackage::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
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
        return view('brandpriers.companyPackages.create');
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
            'cost' => 'required',
            'number_bubbles' => 'required',
            'distribution' => 'required',
            'bonus' => 'required',
            'bubble_expiry' => 'required',
            'top_up_cos' => 'required',
            'average_players' => 'required',
            'added_gift_capabilities' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }


        CompanyPackage::create([
            'cost' => $request->cost,
            'number_bubbles' => $request->number_bubbles,
            'distribution' => $request->distribution,
            'bonus' => $request->bonus,
            'bubble_expiry' => $request->bubble_expiry,
            'top_up_cos' => $request->top_up_cos,
            'average_players' => $request->average_players,
            'added_gift_capabilities' => $request->added_gift_capabilities,
        ]);

        return response()->json(['message' => 'Added Company Package successfully', 'status' => 200]);
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
    public function edit($local, CompanyPackage $companyPackage)
    {
        return view('brandpriers.companyPackages.create', compact('companyPackage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request, CompanyPackage $companyPackage)
    {
        $validations = Validator::make($request->all(), [
            'cost' => 'required',
            'number_bubbles' => 'required',
            'distribution' => 'required',
            'bonus' => 'required',
            'bubble_expiry' => 'required',
            'top_up_cos' => 'required',
            'average_players' => 'required',
            'added_gift_capabilities' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }


        $companyPackage->update([
            'cost' => $request->cost,
            'number_bubbles' => $request->number_bubbles,
            'distribution' => $request->distribution,
            'bonus' => $request->bonus,
            'bubble_expiry' => $request->bubble_expiry,
            'top_up_cos' => $request->top_up_cos,
            'average_players' => $request->average_players,
            'added_gift_capabilities' => $request->added_gift_capabilities,
        ]);

        return response()->json(['message' => 'Update Company Package successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local, CompanyPackage $companyPackage)
    {
        $companyPackage->delete();
    }


    public function indexBrandPackages($locale, $brand_id)
    {

        $brandName = Brand::where('id', $brand_id)->value('brand_name');
        return view('brandpriers.brandPackages.index', compact('brand_id', 'brandName'));
    }

    public function packagesDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = CompanyPackageLogs::Where('brand_id', $request->brand_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('brand_id', function ($data) {
                    $company_package = CompanyPackage::where('id', $data->package_id)->first();
                    if ($company_package != null) {
                        return $company_package->id;
                    } else {
                        return '';
                    }
                })
                ->addColumn('expiry_date', function ($data) {
                    $first_campaign = Campaign::Where('package_logs_id', $data->id)
                        ->orderBy('created_at', 'ASC')
                        ->first(['created_at']);

                    if ($first_campaign != null) {
                        $company_expiry = CompanyPackage::Where('id', $data->package_id)->value('bubble_expiry');
                        $expiry_date = $first_campaign->created_at->addDays($company_expiry);
                        return $expiry_date->format('d/m/Y - g:i A');
                    } else
                        return null;
                })
                ->addColumn('expiry', function ($data) {
                    $first_campaign = Campaign::Where('package_logs_id', $data->id)
                        ->orderBy('created_at', 'ASC')
                        ->first(['created_at']);

                    if ($first_campaign != null) {
                        $company_expiry = CompanyPackage::Where('id', $data->package_id)->value('bubble_expiry');
                        $expiry_date = $first_campaign->created_at->addDays($company_expiry);
                        if($expiry_date <= now())
                        return 'True';
                        else
                            return 'False';
                    }
                })

                ->addColumn('package', function ($data) {
                    $company_package = CompanyPackage::where('id', $data->package_id)->first();
                    if ($company_package != null) {
                        $company_package = 'Cost: ' . $company_package->cost . ' - Number Bubbles: ' . $company_package->number_bubbles;
                        return $company_package;
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d/m/Y - g:i A');
                })
                ->make(true);
        }

    }

    public function createBrandPackages($locale, $brand_id)
    {
        $companyPackages = CompanyPackage::get();
        return view('brandpriers.brandPackages.create', compact('companyPackages', 'brand_id'));
    }

    public function storeBrandPackages(Request $request)
    {

        $validations = Validator::make($request->all(), [
            'companyPackages_id' => 'required',

        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        CompanyPackageLogs::create([
            'brand_id' => $request->brand_id,
            'package_id' => $request->companyPackages_id
        ]);

        return response()->json(['message' => 'Added Package successfully', 'status' => 200]);
    }

    public function destroyBrandPackages($locale, $packages_id)
    {

        CompanyPackageLogs::where('id', $packages_id)->delete();
    }
}
