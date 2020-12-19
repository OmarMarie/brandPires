<?php

namespace App\Http\Controllers\Web;

use App\Models\Tanks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brandpriers.tanks.index');
    }

    public function tanksDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = Tanks::first()->get();
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
        return view('brandpriers.tanks.create');
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
            'price' => 'required',
            'size' => 'required',
            'live_time' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        if (isset($request->tank_icon)) {
            $image = $request->file('tank_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/tank'), $icon);
        } else {
            $icon = null;
        }

        Tanks::create([
            'name' => $request->name,
            'price' => $request->price,
            'size' => $request->size,
            'live_time' => $request->live_time,
            'tank_icon' => $icon


        ]);
        return response()->json(['message' => 'Added Tank successfully', 'status' => 200]);
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
    public function edit($local, Tanks $tank)
    {

        return view('brandpriers.tanks.create', compact('tank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request, Tanks $tank)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'size' => 'required',
            'live_time' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }
        $tank->update([
            'name' => $request->name,
            'price' => $request->price,
            'size' => $request->size,
            'live_time' => $request->live_time,
        ]);
        if (isset($request->tank_icon) && $request->tank_icon != $tank->tank_icon) {
            /*--------------delete img old--------*/
            $file = 'images/tank/' . $tank->tank_icon;
            File::delete($file);

            $image = $request->file('tank_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/tank'), $icon);

            $tank->update([
                'tank_icon' => $icon
            ]);
        }


        return response()->json(['message' => 'Update Tank successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local, Tanks $tank)
    {
        $tank->delete();
        if ($tank->tank_icon != null) {
            $file = 'images/tank/' . $tank->tank_icon;
            File::delete($file);

        }
    }
}
