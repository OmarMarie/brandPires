<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CompanyPackageLogs extends Model
{
    protected $table = 'company_package_logs';
    protected $guarded = [];
    protected $appends = ['expiry'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }


    public function getExpiryAttribute()
    {
        $first_campaign = Campaign::Where('package_logs_id', $this->attributes['id'])
            ->orderBy('start_date', 'ASC')
            ->first(['start_date']);
        if ($first_campaign != null) {
            $company_expiry = Package::Where('id',  $this->attributes['package_id'])->value('bubble_expiry');
            $expiry_date = Carbon::parse($first_campaign->start_date)->addDays($company_expiry);
            if ($expiry_date <= now())
                return 'Yes';
            else
                return 'NO';
        }

    }

}
