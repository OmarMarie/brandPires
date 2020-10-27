<?php

namespace App\Http\Controllers\Web;


use App\Brand;
use App\Models\Attachments;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class AttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($locale, $company_id)
    {
        $companyName = Company::where('id', $company_id)->value('name');
        $attachments = Attachments::where('company_id', $company_id)->first();
        return view('brandpriers.companyAttachments.index', compact('company_id', 'companyName', 'attachments'));
    }

    public function indexBrand($locale, $brand_id)
    {

        $attachments = Brand::where('id', $brand_id)->first();
        return view('brandpriers.brandAttachments.index', compact('brand_id', 'attachments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, $company_id)
    {
        $attachments = Attachments::where('company_id', $company_id)->first();
        return view('brandpriers.companyAttachments.create', compact('company_id', 'attachments'));
    }

    public function editBrand($locale, $brand_id)
    {
        $attachments = Brand::where('id', $brand_id)->first();
        return view('brandpriers.brandAttachments.create', compact('brand_id', 'attachments'));
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
        $attachments = Attachments::where('company_id', $request->company_id)->first();
        if (isset($attachments)) {
            if (isset($request->commercial_registration) && $request->commercial_registration != $attachments->commercial_registration) {
                $validations = Validator::make($request->all(), [
                    'commercial_registration' => 'mimes:jpeg,png,jpg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $file = 'attachments/company/' . $attachments->commercial_registration;
                File::delete($file);
                $image = $request->file('commercial_registration');
                $commercial_registration = 'CR_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $commercial_registration);
                $attachments->update([
                    'commercial_registration' => $commercial_registration
                ]);
            }

            if (isset($request->Identity) && $request->Identity != $attachments->Identity) {
                $validations = Validator::make($request->all(), [
                    'Identity' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $file = 'attachments/company/' . $attachments->Identity;
                File::delete($file);
                $image = $request->file('Identity');
                $Identity = 'id_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $Identity);
                $attachments->update([
                    'Identity' => $Identity
                ]);
            }

            if (isset($request->bank_account) && $request->bank_account != $attachments->bank_account) {
                $validations = Validator::make($request->all(), [
                    'bank_account' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $file = 'attachments/company/' . $attachments->bank_account;
                File::delete($file);
                $image = $request->file('bank_account');
                $bank_account = 'bank_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $bank_account);
                $attachments->update([
                    'bank_account' => $bank_account
                ]);
            }

            if (isset($request->privacy_policy) && $request->privacy_policy != $attachments->privacy_policy) {
                $validations = Validator::make($request->all(), [
                    'privacy_policy' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $file = 'attachments/company/' . $attachments->privacy_policy;
                File::delete($file);
                $image = $request->file('privacy_policy');
                $privacy_policy = 'privacy_policy_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $privacy_policy);
                $attachments->update([
                    'privacy_policy' => $privacy_policy
                ]);
            }

        }
        else
        {
            if (isset($request->commercial_registration)) {
                $validations = Validator::make($request->all(), [
                    'commercial_registration' => 'mimes:jpeg,png,jpg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $image = $request->file('commercial_registration');
                $commercial_registration = 'CR_'.time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $commercial_registration);
            }
            if (isset($request->Identity)) {
                $validations = Validator::make($request->all(), [
                    'Identity' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $image = $request->file('Identity');
                $Identity = 'id_'.time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $Identity);
            }
            if (isset($request->bank_account)) {
                $validations = Validator::make($request->all(), [
                    'bank_account' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $image = $request->file('bank_account');
                $bank_account = 'bank_'.time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $bank_account);
            }
            if (isset($request->privacy_policy)) {
                $validations = Validator::make($request->all(), [
                    'privacy_policy' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $image = $request->file('privacy_policy');
                $privacy_policy = 'privacy_policy_'.time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/company'), $privacy_policy);
            }

            Attachments::create
            ([
                'company_id' =>$request->company_id,
                'commercial_registration' => $commercial_registration,
                'Identity' => $Identity,
                'bank_account' => $bank_account,
                'privacy_policy' =>$privacy_policy,
            ]);

        }
        return response()->json(['message' => 'update Attachment successfully', 'status' => 200]);
    }

    public function updateBrand(Request $request, $id)
    {
        $attachments = Brand::where('id', $request->brand_id)->first();
        if (isset($attachments)) {
            if (isset($request->contract) && $request->contract != $attachments->contract) {
                $validations = Validator::make($request->all(), [
                    'contract' => 'mimes:jpeg,png,jpg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $file = 'attachments/brand/' . $attachments->contract;
                File::delete($file);
                $image = $request->file('contract');
                $contract = 'contract_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/brand'), $contract);
                $attachments->update([
                    'contract' => $contract
                ]);
            }

            if (isset($request->ad_approval) && $request->ad_approval != $attachments->ad_approval) {
                $validations = Validator::make($request->all(), [
                    'ad_approval' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                ]);

                if ($validations->fails()) {
                    return response()->json(['errors' => $validations->errors(), 'status' => 422]);
                }
                $file = 'attachments/brand/' . $attachments->ad_approval;
                File::delete($file);
                $image = $request->file('ad_approval');
                $ad_approval = 'ad_approval_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('attachments/brand'), $ad_approval);
                $attachments->update([
                    'ad_approval' => $ad_approval
                ]);
            }



        }
        return response()->json(['message' => 'update Attachment successfully', 'status' => 200]);
    }
}
