<?php

namespace App\Http\Controllers\Web;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        return view('brandpriers.brands.create');
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
            'brand_name' => 'required',
            'total_bubbles_number' => 'required|numeric',
            'total_gifts_number' => 'required|numeric',
            'total_price' => 'required|numeric',
            'status' => 'required',
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

        Brand::create([
            'brand_name' => $request->brand_name,
            'total_bubbles_number' => $request->total_bubbles_number,
            'total_gifts_number' => $request->total_gifts_number,
            'total_price' => $request->total_price,
            'status' => $request->status,
            'img' => $icon,
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
        return view('brandpriers.brands.create', compact('brand'));
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
            'brand_name' => 'required',
            'total_bubbles_number' => 'required|numeric',
            'total_gifts_number' => 'required|numeric',
            'total_price' => 'required|numeric',
            'status' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $brand->update([
            'brand_name' => $request->brand_name,
            'total_bubbles_number' => $request->total_bubbles_number,
            'total_gifts_number' => $request->total_gifts_number,
            'total_price' => $request->total_price,
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
