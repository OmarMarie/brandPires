<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BubblesTransferAction extends Model
{
    protected $fillable = [
      'player_tank_id', 'player_id', 'bubbles_number'
    ];
}
