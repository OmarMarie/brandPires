<?php

namespace App\Http\Controllers\Web;

use App\Models\Bubbles;
use App\Models\City;
use App\Models\Country;
use App\Models\Gift;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($local, $campaign_id)
    {
        return view('brandpriers.gifts.index', compact('campaign_id'));
    }

    public function giftsDatable(Request $request)
    {
        if ($request->ajax()) {
            $gift_id = Bubbles::Where('campaign_id', $request->campaign_id)->pluck('gift_id');
            $data = Gift::whereIn('id', $gift_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('country_id', function ($data) {
                    $country = Country::where('id', $data->country_id)->first();
                    if ($country != null) {
                        return $country->name;
                    } else {
                        return '';
                    }
                })
                ->editColumn('city_id', function ($data) {
                    $city = City::where('id', $data->city_id)->first();
                    if ($city != null) {
                        return $city->name;
                    } else {
                        return '';
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
    public function create($local, $campaign_id)
    {
        $countries = Country::where('status', 1)->get();
        return view('brandpriers.gifts.create', compact('campaign_id', 'countries'));
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
            'code_number' => 'required',
            'gift_from' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'center' => 'required',
            'date_of_coupon' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $bubbles = Bubbles::Where('campaign_id', $request->campaign_id)
            ->where('gift_id', null)
            ->first();

        if (isset($request->gift_icon)) {
            $image = $request->file('gift_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/gift'), $icon);
        } else {
            $icon = null;
        }
        $gift = Gift::create([
            'name' => $request->name,
            'code_number' => $request->code_number,
            'gift_from' => $request->gift_from,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'center' => $request->center,
            'date_of_coupon' => Carbon::parse($request->date_of_coupon)->format('Y-m-d'),
            'img' => $icon,
            'bubble_id' => $bubbles->id
        ]);

        $bubbles->update([
            'gift_id' => $gift->id
        ]);


        return response()->json(['message' => 'Added Gift successfully', 'status' => 200]);
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
    public function edit($local,Gift $gift)
    {
        $countries = Country::where('status', 1)->get();
        return view('brandpriers.gifts.create', compact('gift','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($local,Request $request, Gift $gift)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'code_number' => 'required',
            'gift_from' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'center' => 'required',
            'date_of_coupon' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $gift->update([
            'name' => $request->name,
            'code_number' => $request->code_number,
            'gift_from' => $request->gift_from,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'center' => $request->center,
            'date_of_coupon' => Carbon::parse($request->date_of_coupon)->format('Y-m-d'),
        ]);

        if (isset($request->gift_icon) && $request->gift_icon != $gift->img) {
            /*--------------delete img old--------*/
            $file = 'images/gift/' . $gift->img;
            File::delete($file);

            $image = $request->file('gift_icon');
            $icon = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/gift'), $icon);

            $gift->update([
                'img' => $icon
            ]);

        }

        return response()->json(['message' => 'Update Gift successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($local,Gift $gift)
    {
        //
    }
}
