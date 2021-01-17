<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{

    protected $fillable = [
        'player_id', 'friend_id','status'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function friends()
    {
        return $this->belongsTo(Player::class, 'friend_id');
    }

    // status
    const REQUEST_FRIEND = 0;
    const APPROVED = 1;
    const SEEN_AND_PENDING = 2;
    const DISAPPROVE = 3;

}
