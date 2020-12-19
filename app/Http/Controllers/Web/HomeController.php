<?php

namespace App\Http\Controllers\Web;

use App\Models\Brand;
use App\Models\Bubbles;
use App\Models\BubblesTransferAction;
use App\Models\Campaign;
use App\Models\City;
use App\Models\CompanyPackageLogs;
use App\Models\Player;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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


        $mapCampaigns = Campaign::Where('end_date', '>=', date('Y-m-d'))->where('available', 1)->get(['id', 'name', 'lat', 'lng']);
        $marker_code = '';
        foreach ($mapCampaigns as $value) {
            $marker_code .= '[' . '"' . $value->name . '"' . ',' . $value->lat . ',' . $value->lng . ',' . $value->id . '],';

        }
        $marker_code = substr_replace($marker_code, "", -1);


        $data = DB::table('company_package_logs')
            ->leftJoin('packages', 'company_package_logs.package_id', '=', 'packages.id')
            ->select(DB::raw('MONTH(company_package_logs.created_at) month'), DB::raw('sum(packages.cost) as `value`'))
            ->whereYear('company_package_logs.created_at', date('Y'))
            ->orderBy('month', 'ASC')
            ->groupBy('month')
            ->get();

        foreach ($data as $datum) {
            $salesSum = +$datum->value;
        }

        return view('brandpriers.dashboard.index',
            compact('brands', 'campaigns', 'players', 'bubbles_transfer'
                , 'activeCampaigns', 'inActiveCampaigns', 'finishedCampaigns', 'stoppedCampaigns',
                'percentageBrands', 'percentageBubblesPlayer', 'percentageBubblesTransfer'
                , 'percentageCampaign', 'mapCampaigns', 'marker_code', 'salesSum'));
    }

    public function resetPassword()
    {
        return view('auth.passwords.reset');
    }

    public function players()
    {
        $players = Player::get();
        $playersCount = Player::count();
        $active_now = Player::where('is_online', '1')->count();
        $male = Player::where('gender', '1')->count();
        $female = Player::where('gender', '2')->count();

        $ageUnder18 = 0;
        $ageBetween19to35 = 0;
        $ageAbove35 = 0;
        foreach ($players as $player) {
            $age = Carbon::parse($player->birth_day)->age;
            if ($age <= 18)
                $ageUnder18++;
            elseif ($age > 18 && $age < 35)
                $ageBetween19to35++;
            elseif ($age >= 35)
                $ageAbove35++;
        }

        return view('brandpriers.dashboard.players',
            compact('playersCount', 'active_now', 'male', 'female', 'ageUnder18', 'ageBetween19to35', 'ageAbove35'));
    }

    public function sales()
    {
        $data = DB::table('company_package_logs')
            ->leftJoin('packages', 'company_package_logs.package_id', '=', 'packages.id')
            ->select(DB::raw('MONTH(company_package_logs.created_at) month'), DB::raw('sum(packages.cost) as `value`'))
            ->whereYear('company_package_logs.created_at', date('Y'))
            ->orderBy('month', 'ASC')
            ->groupBy('month')
            ->get();

        foreach ($data as $datum) {
            $dateObj = DateTime::createFromFormat('!m', $datum->month);
            $datum->month = $monthName = $dateObj->format('F');
        }

        $array = [
            'sales' => $data,
        ];
        return $array;
    }

    public function mapCampaign($local, $lat, $lng)
    {

        $campaigns = Campaign::where('available', 1)
            ->Where('end_date', '>=', date('Y-m-d'))
            ->where('lat', $lat)
            ->where('lng', $lng)
            ->get();
        foreach ($campaigns as $campaign) {
            $campaign['count_bubbles'] = Bubbles::where('campaign_id', $campaign->id)->count();
            $campaign['count_bubbles_not_hooked'] = Bubbles::where('campaign_id', $campaign->id)
                ->where('status', 0)->count();
            $campaign['count_bubbles_hooked'] = $campaign['count_bubbles'] - $campaign['count_bubbles_not_hooked'];
        }
        return view('brandpriers.dashboard.map', compact('campaigns'));

    }

    public function getCities($local, $country_id)
    {
        $cities = City::where('country_id', $country_id)->get();
        return $cities;

    }


}
