<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPackageLogs extends Model
{
    protected $table = 'company_package_logs';
    protected $guarded = [];


    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

}
