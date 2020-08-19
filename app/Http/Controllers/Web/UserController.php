<?php

namespace App\Http\Controllers\web;

use App\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('brandpriers.users.index');
    }

    public function usersDatable(Request $request)
    {


        if ($request->ajax()) {
            $data = User::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($data) {
                    $type = $data->roles;
                    foreach ($type as $object) {
                        return $object->name;
                    }
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
        $roles = Role::latest()->get();
        return view('brandpriers.users.create', compact('roles'));
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
            'email' => 'required|unique:users',
            'role' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $password = mt_rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'type' => $request->role,
            'phone_number' => $request->phone
        ]);

        RoleUser::create([
            'role_id' => $request->role,
            'user_id' => $user->id
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $requst, User $user)
    {
      $role_user= $user->roles;
        foreach ($role_user as $object) {
            $id_role_user =$object->id;
        }
        $roles = Role::latest()->get();
        return view('brandpriers.users.create', compact('user','roles','id_role_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request,  User $user)
    {

        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->role,
            'phone_number' => $request->phone
        ]);

        $roleUser=RoleUser::where('user_id', $user->id)->first();
        $user->roles($roleUser)->save();


        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local, $id)
    {
        //
    }
}
