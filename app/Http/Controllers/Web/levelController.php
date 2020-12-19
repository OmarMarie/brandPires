<?php

namespace App\Http\Controllers\Web;

use App\Models\Levels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class levelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brandpriers.levels.index');
    }

    public function levelsDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Levels::first()->get();

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
        return view('brandpriers.levels.create');
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

            'level_name' => 'required',
            'from_pts' => 'required',
            'to_pts' => 'required',
            'extra' => 'required',
            'speed' => 'required',
            'duration' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        if (isset($request->level_icon)) {
            $image = $request->file('level_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/level'), $icon);
        } else {
            $icon = null;
        }

       Levels::create([
            'level_name' => $request->level_name,
            'from_pts' => $request->from_pts,
            'to_pts' => $request->to_pts,
            'extra' => $request->extra,
            'speed' => $request->speed,
            'duration' => $request->duration,
            'level_icon' => $icon

        ]);
        return response()->json(['message' => 'Added Level successfully', 'status' => 200]);

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
    public function edit($local,Levels $level)
    {
        return view('brandpriers.levels.create',compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local,Request $request, Levels $level)
    {
        $validations = Validator::make($request->all(), [

            'level_name' => 'required',
            'from_pts' => 'required',
            'to_pts' => 'required',
            'extra' => 'required',
            'speed' => 'required',
            'duration' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }
        $level->update([
            'level_name' => $request->level_name,
            'from_pts' => $request->from_pts,
            'to_pts' => $request->to_pts,
            'extra' => $request->extra,
            'speed' => $request->speed,
            'duration' => $request->duration
        ]);

        if (isset($request->level_icon) && $request->level_icon != $level->level_icon) {
            /*--------------delete img old--------*/
            $file = 'images/level/' . $level->level_icon;
            File::delete($file);

            $image = $request->file('level_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/level'), $icon);

            $level->update([
                'level_icon' => $icon
            ]);

        }
        return response()->json(['message' => 'Updated Level successfully', 'status' => 200]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local,$id)
    {
        $level = Levels::where('id', $id)->first();
        $level->delete();
        $file = 'images/level/' . $level->level_icon;
        File::delete($file);
    }
}
