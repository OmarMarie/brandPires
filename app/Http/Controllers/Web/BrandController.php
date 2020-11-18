<?php

namespace App\Http\Controllers\Web;


use App\Models\Brand;
use App\Models\BrandCampaign;
use App\Models\Company;
use App\Models\CompanyPackage;
use App\Models\CompanyPackageLogs;
use App\Models\Package;
use App\Models\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {

        return view('brandpriers.brands.index');
    }

    public function brandsDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = Brand::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($data) {
                    return $data->status == 0 ? 'False' : 'True';
                })
                ->editColumn('company_id', function ($data) {
                   $companyName=Company::where('id',$data->company_id)->value('name');
                   if($companyName != '')
                    return $companyName;
                   else
                       return null;

                })
                ->editColumn('created_at', function ($data) {
                    if ($data->created_at != '')
                        $data->created_at->format('d m Y - g:i A');
                    return $data->created_at;
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
        $companyPackages=Package::get();
        $companies=Company::get();
        return view('brandpriers.brands.create',compact('companyPackages','companies'));
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
            'brand_name' => 'required|unique:brands',
            'company_id' => 'required',
            'status' => 'required',
            'contract' => 'required|mimes:jpeg,png,jpg,pdf',
            'ad_approval' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            'name_user' => 'required',
            'email' => 'required|unique:users',
            'phone' =>'required|min:9|numeric',
            'password' =>'required|min:8'
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        if (isset($request->brand_icon)) {
            $image = $request->file('brand_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/brand'), $icon);
        } else {
            $icon = null;
        }

        if (isset($request->contract)) {
            $image = $request->file('contract');
            $contract = 'contract_'.time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('attachments/brand'), $contract);
        }
        if (isset($request->ad_approval)) {
            $image = $request->file('ad_approval');
            $ad_approval = 'ad_approval_'.time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('attachments/brand'), $ad_approval);
        }


        $user = User::create([
            'name' => $request->name_user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 3,
            'phone_number' => $request->phone
        ]);

        RoleUser::create([
            'role_id' => 3,
            'user_id' => $user->id
        ]);

         Brand::create([
            'brand_name' => $request->brand_name,
            'status' => $request->status,
            'img' => $icon,
            'user_id' => $user->id,
            'company_id' => $request->company_id,
            'contract' => $contract,
            'ad_approval' => $ad_approval
        ]);


        return response()->json(['message' => 'Added Brand successfully', 'status' => 200]);
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
    public function edit($local, Brand $brand)

    {
        $companyPackages=Package::get();
        return view('brandpriers.brands.create', compact('brand','companyPackages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request, Brand $brand)
    {
        $validations = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands,brand_name,'.$brand->id,
            'status' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $brand->update([
            'brand_name' => $request->brand_name,
            'status' => $request->status,
        ]);

        if (isset($request->brand_icon) && $request->brand_icon != $brand->img) {
            /*--------------delete img old--------*/
            $file = 'images/brand/' . $brand->img;
            File::delete($file);

            $image = $request->file('brand_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/brand'), $icon);

            $brand->update([
                'img' => $icon
            ]);

        }
        return response()->json(['message' => 'Updated Brand successfully', 'status' => 200]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local, Brand $brand)
    {
        $brand->delete();
        if ($brand->img != null) {
            $file = 'images/tank/' . $brand->img;
            File::delete($file);

        }
    }
}
