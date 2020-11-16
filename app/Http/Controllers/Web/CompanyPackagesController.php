<?php

namespace App\Http\Controllers\Web;


use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CompanyPackageLogs;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CompanyPackagesController extends Controller
{

    public function indexBrandPackages($locale, $brand_id)
    {

        $brandName = Brand::where('id', $brand_id)->value('brand_name');
        return view('brandpriers.brandPackages.index', compact('brand_id', 'brandName'));
    }

    public function companyPackagesDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = CompanyPackageLogs::Where('brand_id', $request->brand_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('brand_id', function ($data) {
                    $company_package = Package::where('id', $data->package_id)->first();
                    if ($company_package != null) {
                        return $company_package->id;
                    } else {
                        return '';
                    }
                })
                ->addColumn('expiry_date', function ($data) {
                    $first_campaign = Campaign::Where('package_logs_id', $data->id)
                        ->orderBy('start_date', 'ASC')
                        ->first(['start_date']);

                    if ($first_campaign != null) {
                        $company_expiry = Package::Where('id', $data->package_id)->value('bubble_expiry');
                        $expiry_date = Carbon::parse($first_campaign->start_date)->addDays($company_expiry);
                        return $expiry_date->format('d/m/Y - g:i A');
                    } else
                        return null;
                })
                ->addColumn('expiry', function ($data) {
                    $first_campaign = Campaign::Where('package_logs_id', $data->id)
                        ->orderBy('start_date', 'ASC')
                        ->first(['start_date']);

                    if ($first_campaign != null) {
                        $company_expiry = Package::Where('id', $data->package_id)->value('bubble_expiry');
                        $expiry_date = Carbon::parse($first_campaign->start_date)->addDays($company_expiry);
                        if($expiry_date <= now())
                        return 'True';
                        else
                            return 'False';
                    }
                })

                ->addColumn('package', function ($data) {
                    $company_package = Package::where('id', $data->package_id)->first();
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
        $companyPackages = Package::get();
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
