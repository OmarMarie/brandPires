<?php

namespace App;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class);
    }

}
