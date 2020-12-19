<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTankAction extends Model
{
    protected $fillable = [
      'tank_id', 'player_id', 'action'
    ];

    public function tanks()
    {
        return $this->belongsTo(Tanks::class, 'tank_id');
    }
}
