<?php

namespace App;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class);
    }

}
