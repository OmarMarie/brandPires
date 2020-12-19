<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatting extends Model
{
    protected $fillable = [
      'sender_id', 'receiver_id', 'content', 'content_type',
        'status'
    ];

    public function sender()
    {
        return $this->belongsTo(Player::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Player::class,'receiver_id');
    }

}
