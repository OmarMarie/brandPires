<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftAction extends Model
{
    protected $guarded = [];

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'bubble_id' , 'bubble_id');
    }
}
