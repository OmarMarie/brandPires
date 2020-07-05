<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{
    protected $fillable = [
      'level_name', 'level_pts'
    ];
}
