<?php

namespace App\Http\Controllers\Web;


use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Country::get();
        foreach ($data as $datum) {
            $journalName = $datum->flag;
            $journalName = str_replace('_', '-', $journalName);
            $datum->update([
                'flag' => $journalName,
            ]);

        }
        return view('brandpriers.countries.index');
    }

    public function countriesDatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Country::orderByDesc('status')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($data) {
                    return $data->status == 0 ? 'False' : 'True';
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

    public function statusChange($local, $id)
    {
        $country = Country::where('id', $id)->first();
        if ($country->status == 0) {
            $country->update([
                'status' => 1,
            ]);
        } else {
            $country->update([
                'status' => 0,
            ]);
        }

    }

}
