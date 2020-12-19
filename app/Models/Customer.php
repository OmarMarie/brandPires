<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'brand_name', 'total_bubbles_number',
        'total_gifts_number', 'remarks',
        'status', 'campaign_id', 'img'
    ];

    public function campaigns()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
