<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
      'player_id', 'friend_id'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function friends()
    {
        return $this->belongsTo(Player::class, 'friend_id');
    }
}
