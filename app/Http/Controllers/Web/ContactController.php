<?php

namespace App\Http\Controllers\Web;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($locale, $company_id)
    {

        $companyName = Company::where('id', $company_id)->value('name');
        return view('brandpriers.companyContacts.index', compact('company_id', 'companyName'));
    }

    public function contactsDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = Contact::Where('company_id', $request->company_id)->latest()->get();
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
    public function create($locale, $company_id)
    {
        return view('brandpriers.companyContacts.create', compact('company_id'));
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
            'job_title' => 'required',
            'phone' => 'required|numeric|min:9',
            'email' => 'required|email',


        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Contact::create([
            'name' => $request->name,
            'job_title' => $request->job_title,
            'phone' => $request->phone,
            'email' => $request->email,
            'company_id' => $request->company_id
        ]);

        return response()->json(['message' => 'Added Company successfully', 'status' => 200]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($locale, $id)
    {
        Contact::Where('id', $id)->delete();
    }
}
