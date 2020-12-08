<?php

namespace App\Http\Controllers\Web;

use App\Models\Attachments;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brandpriers.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brandpriers.companies.create');
    }

    public function CompanyDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = Company::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($data) {
                    return $data->status == 0 ? 'False' : 'True';
                })
                ->make(true);
        }

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
            'name' => 'required|unique:companies',
            'status' => 'required',
            'commercial_registration_no' => 'required',
            'expiry_date_commercial_registration' => 'required',
            'iban' => 'required',
            'email_company' => 'required|email',
            'phone' => 'required|min:9|numeric',
            'commercial_registration' => 'required|mimes:jpeg,png,jpg,pdf',
            'Identity' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            'bank_account' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            'privacy_policy' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            'name_user' => 'required',
            'email' => 'required|email|unique:users',
            'phone_user' => 'required|min:9|numeric',
            'password' => 'required|min:8'


        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        if (isset($request->icon)) {
            $image = $request->file('icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/company'), $icon);
        }
        $type= ["Company"];

        $user = User::create([
            'name' => $request->name_user,
            'email' => $request->email,
            'type' =>json_encode($type) ,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_user
        ]);

        $user->assignRole([2]);


        $company = Company::create([
            'name' => $request->name,
            'commercial_registration_no' => $request->commercial_registration_no,
            'expiry_date_CR' => Carbon::parse($request->expiry_date_commercial_registration)->format('Y/m/d'),
            'iban' => $request->iban,
            'email' => $request->email_company,
            'phone' => $request->phone,
            'logo' => $icon,
            'status' => $request->status,
            'user_id' => $user->id
        ]);

        if (isset($request->commercial_registration)) {
            $image = $request->file('commercial_registration');
            $commercial_registration = 'CR_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('attachments/company'), $commercial_registration);
        }
        if (isset($request->Identity)) {
            $image = $request->file('Identity');
            $Identity = 'id_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('attachments/company'), $Identity);
        }
        if (isset($request->bank_account)) {
            $image = $request->file('bank_account');
            $bank_account = 'bank_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('attachments/company'), $bank_account);
        }
        if (isset($request->privacy_policy)) {
            $image = $request->file('privacy_policy');
            $privacy_policy = 'privacy_policy_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('attachments/company'), $privacy_policy);
        }

        Attachments::create
        ([
            'company_id' => $company->id,
            'commercial_registration' => $commercial_registration,
            'Identity' => $Identity,
            'bank_account' => $bank_account,
            'privacy_policy' => $privacy_policy,
        ]);

        return response()->json(['message' => 'Added Campaign successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit($local, Company $company)
    {
        return view('brandpriers.companies.create', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request, Company $company)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required|unique:companies,name,' . $company->id,
            'status' => 'required',
            'commercial_registration_no' => 'required',
            'expiry_date_commercial_registration' => 'required',
            'iban' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:9|numeric',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }
        $company->update([
            'name' => $request->name,
            'commercial_registration_no' => $request->commercial_registration_no,
            'expiry_date_CR' => Carbon::parse($request->expiry_date_commercial_registration)->format('Y/m/d'),
            'iban' => $request->iban,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        if (isset($request->icon) && $request->icon != $company->logo) {

            /*--------------delete img old--------*/
            $file = 'images/company/' . $company->logo;
            File::delete($file);

            $image = $request->file('icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/company'), $icon);

            $company->update([
                'logo' => $icon
            ]);

        }
        return response()->json(['message' => 'Updated Company successfully', 'status' => 200]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {

    }
}
