<?php

namespace App\Http\Controllers\Web;


use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('brandpriers.packages.index');
    }

    public function packagesDatable(Request $request)
    {

        if ($request->ajax()) {
            $data = Package::latest()->get();
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
        return view('brandpriers.packages.create');
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
            'number_bubbles' => 'required|Numeric',
            'distribution' => 'required',
            'bonus' => 'required',
            'bubble_expiry' => 'required|Numeric',
            'top_up_cos' => 'required',
            'average_players' => 'required',
            'added_gift_capabilities' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }


        Package::create([
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
    public function edit($local, Package $package)
    {
        return view('brandpriers.packages.create', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local, Request $request, Package $package)
    {
        $validations = Validator::make($request->all(), [
            'cost' => 'required',
            'number_bubbles' => 'required|Numeric',
            'distribution' => 'required',
            'bonus' => 'required',
            'bubble_expiry' => 'required|Numeric',
            'top_up_cos' => 'required',
            'average_players' => 'required',
            'added_gift_capabilities' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }


        $package->update([
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
    public function destroy($local, Package $package)
    {
        $package->delete();
    }

}
