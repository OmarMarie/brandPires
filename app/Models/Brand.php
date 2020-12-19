<?php

namespace  App\Models;

use App\Models\BrandCampaign;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function brandCampaigns()
    {
        return $this->hasMany(Campaign::class, 'brand_id', 'id');
    }

}
