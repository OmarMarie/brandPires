<?php

namespace App\Http\Controllers\Web;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brandpriers.employees.index');
    }

    public function employeesDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('active', function ($data) {
                    return $data->active == 0 ? 'False' : 'True';
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
        return view('brandpriers.employees.create');
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
            'email' => 'required|unique:employees',
            'password' => 'required',
            'phone_number' => 'required',
            'active' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'active' => $request->active,

        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($local, Employee $employee)
    {
        return view('brandpriers.employees.create', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request, Employee $employee)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'phone_number' => 'required',
            'active' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'active' => $request->active,

        ]);

        return response()->json(['message' => 'Update successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local, Employee $employee)
    {
        $employee->delete();
    }
}
