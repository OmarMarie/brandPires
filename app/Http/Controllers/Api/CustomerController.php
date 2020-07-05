<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use App\Models\Customer;
use App\Traits\ApiResponser;

class CustomerController extends Controller
{
    use ApiResponser;
    public function index()
    {

        $customers = Customer::with('campaigns')->get();

        $campaigns = Campaign::with('customers')->get();

        $allCustomers = Customer::all();
        return $campaigns;
    }

    public function customers()
    {

        $customers = Customer::all();

        return $customers;
    }

    public function campaigns($id)
    {
        $campaigns = Campaign::where('customer_id', $id)->get();

        if (count($campaigns) == 0)
        {
            return response()->json([
                'data' => null,
                'message' => 'Campaign not found',
            ], 404);
        }
        else {
            return response()->json([
                'data' => $campaigns,
            ], 200);
        }

    }
}
