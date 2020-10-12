<?php

namespace App\Http\Controllers\Web;


use App\Models\Bulks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BulkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brandpriers.bulks.index');
    }

    public function bulksDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Bulks::get();
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
        return view('brandpriers.bulks.create');
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
            'cost' => 'required',
            'number_of_bubbles' => 'required',
            'bonus' => 'required',
            'duration' => 'required',
            'top_up_cost' => 'required',
            'average_players' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Bulks::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'number_of_bubbles' => $request->number_of_bubbles,
            'bonus' => $request->bonus,
            'duration' => $request->duration,
            'top_up_cost' => $request->top_up_cost,
            'average_players' => $request->average_players,

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
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($local,Bulks $bulk)
    {
        return view('brandpriers.bulks.create',compact('bulk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local,Request $request,Bulks $bulk)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'cost' => 'required',
            'number_of_bubbles' => 'required',
            'bonus' => 'required',
            'duration' => 'required',
            'top_up_cost' => 'required',
            'average_players' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $bulk->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'number_of_bubbles' => $request->number_of_bubbles,
            'bonus' => $request->bonus,
            'duration' => $request->duration,
            'top_up_cost' => $request->top_up_cost,
            'average_players' => $request->average_players,

        ]);

        return response()->json(['message' => 'Update successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local,Bulks $bulk)
    {
        $bulk->delete();
    }
}
