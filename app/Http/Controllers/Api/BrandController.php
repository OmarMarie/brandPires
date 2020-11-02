<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Models\Campaign;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $brands = Brand::with(array('campaigns' => function ($query) {
            return $query->where('available', 1);
        }))
            ->where('status', 1)
            ->paginate(10);

        foreach ($brands as $brand)
        {
            $brand['img'] = env('APP_URL').'/brand/'.$brand['img'];
        }
        return $this->apiResponse($brands, null, 200);
    }

    public function campaigns(Request $request)
    {
        $campaigns = Campaign::whereHas('brands')
            ->where('brand_id', $request->campaign_id)
            ->paginate(10, ['id', 'name', 'mark_pts', 'from_time', 'to_time']);

        if (count($campaigns) == 0) {
            return $this->apiResponse(null, 'Campaign not found', 200, 1);
        } else {
            return $this->apiResponse($campaigns, null, 200);
        }
    }

    public function campaignDetails(Request $request)
    {
        try {
            $campaign = Campaign::findOrFail($request->campaing_id);
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse(null, 'Campaign not found', 200, 1);
        }
        $day = Carbon::parse($campaign->date)->format('l');
        $arr = [
            'name' => $campaign->name,
            'lat' => $campaign->lat,
            'lng' => $campaign->lng,
            'from_time' => $campaign->from_time,
            'to_time' => $campaign->to_time,
            'mark_pts' => $campaign->mark_pts,
            'day' => $day,
            'date' => $campaign->date
        ];
        return $this->apiResponse($arr, '', 200, 1);
        /*return response()->json([
            'name' => $campaign->name,
            'lat' => $campaign->lat,
            'lng' => $campaign->lng,
            'from_time' => $campaign->from_time,
            'to_time' => $campaign->to_time,
            'mark_pts' => $campaign->mark_pts,
            'day' => $day,
            'date' => $campaign->date
        ]);*/
    }
}
