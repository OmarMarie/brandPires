<?php

namespace App\Http\Controllers\Web;

use App\Models\Brand;
use App\Models\BubblesTransferAction;
use App\Models\Campaign;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {

        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $brands = Brand::count();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $weekNumberBrands = Brand::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $subWeekNumberBrands = Brand::whereBetween('created_at', [$weekStart->subWeek(1), $weekEnd->subWeek(1)])->count();
        $percentageBrands = (($subWeekNumberBrands - $weekNumberBrands) / 100) * 100;

        $campaigns = Campaign::count();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $weekNumberCampaign = Campaign::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $subWeekNumberCampaign = Campaign::whereBetween('created_at', [$weekStart->subWeek(1), $weekEnd->subWeek(1)])->count();
        $percentageCampaign = (($subWeekNumberCampaign - $weekNumberCampaign) / 100) * 100;


        $bubbles_transfer = BubblesTransferAction::count();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $weekNumberBubblesTransfer = BubblesTransferAction::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $subWeekNumberBubblesTransfer = BubblesTransferAction::whereBetween('created_at', [$weekStart->subWeek(1), $weekEnd->subWeek(1)])->count();
        $percentageBubblesTransfer = (($subWeekNumberBubblesTransfer - $weekNumberBubblesTransfer) / 100) * 100;


        $players = Player::count();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $weekNumberPlayer = Player::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $subWeekNumberPlayer = Player::whereBetween('created_at', [$weekStart->subWeek(1), $weekEnd->subWeek(1)])->count();
        $percentageBubblesPlayer = (($subWeekNumberPlayer - $weekNumberPlayer) / 100) * 100;

        $activeCampaigns = Campaign::where('available', 1)->count();
        $inActiveCampaigns = Campaign::where('available', 0)->count();
        $finishedCampaigns = Campaign::where('created_at', '<', Carbon::now())->count();
        $stoppedCampaigns = Campaign::where('deleted_at', '!=', null)->count();


        $mapCampaigns = Campaign::Where('date', '>=', date('Y-m-d'))->where('available', 1)->get(['id','name','lat','lng']);
        $marker_code='';
       foreach ($mapCampaigns as $value)
       {
           $marker_code .= '[' . '"'.$value->name .'"'.',' . $value->lat . ',' . $value->lng . ',' . $value->id. '],';

       }
         $marker_code=substr_replace($marker_code ,"", -1);
        return view('brandpriers.dashboard.index',
            compact('brands', 'campaigns', 'players', 'bubbles_transfer'
                , 'activeCampaigns', 'inActiveCampaigns', 'finishedCampaigns', 'stoppedCampaigns',
                'percentageBrands', 'percentageBubblesPlayer', 'percentageBubblesTransfer'
                , 'percentageCampaign','mapCampaigns','marker_code'));
    }



}
