<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerBubbles extends Model
{
    protected $fillable = [
      'player_id', 'bubble_id','status','replaced_by'
    ];

    public function bubbles()
    {
        return $this->belongsTo(Bubbles::class, 'bubble_id');
    }
}
