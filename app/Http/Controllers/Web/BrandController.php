<?php

namespace App\Http\Controllers\Web;

use App\Brand;
use Illuminate\Http\Request;
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
                    if($data->created_at != '')
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
