<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Models\Campaign;
use App\Traits\ApiResponser;
use App\Traits\MessageLanguage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    use ApiResponser,MessageLanguage;

    public function index(Request $request)
    {
        $this->checkLang($request);
        $brands = Brand::with(array('campaigns' => function ($query) {
            return $query->where('available', 1);
        }))
            ->where('status', 1)
            ->paginate(10);

        foreach ($brands as $brand) {
            $brand['img'] = env('APP_URL') . '/images/brand/' . $brand['img'];
        }
        return $this->apiResponse($brands, null, 200);
    }

    public function campaigns(Request $request)
    {
        $this->checkLang($request);
        $campaigns = Campaign::whereHas('brands')
            ->where('brand_id', $request->campaign_id)
            ->paginate(10, ['id', 'name', 'mark_pts', 'from_time', 'to_time']);

        if (count($campaigns) == 0) {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Campaign not found';
                    break;
                case 'ar':
                    $message = "الحملة غير موجودة";
                    break;
                default:
                    $message = 'Campaign not found';
                    break;
            }
            return $this->apiResponse(null,$message , 200, 1);
        } else {
            return $this->apiResponse($campaigns, null, 200);
        }
    }

    public function campaignDetails(Request $request)
    {
        $this->checkLang($request);
        $validator = Validator::make($request->all(), [
            'campaing_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = collect([]);
            foreach ($validator->messages()->all() as $item) {
                $errors->push($item);
            }
            return $this->apiResponse(null, $errors, 422, 0);
        }

        try {
            $campaign = Campaign::findOrFail($request->campaing_id);
        } catch (ModelNotFoundException $e) {
            switch ($request->header('lang')) {
                case 'en':
                    $message = 'Campaign not found';
                    break;
                case 'ar':
                    $message = "الحملة غير موجودة";
                    break;
                default:
                    $message = 'Campaign not found';
                    break;
            }
            return $this->apiResponse(null, $message, 200, 1);
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

    }
}
