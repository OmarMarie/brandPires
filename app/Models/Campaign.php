<?php

namespace App\Models;

use App\Brand;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot', 'deleted_at'];
   /* protected $fillable = [
        'bubbles_bulk', 'lat', 'lng',
        'mark_pts', 'customer_id', 'employee_id', 'from_time', 'to_time', 'date'
    ];*/

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
