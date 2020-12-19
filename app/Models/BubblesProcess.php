<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BubblesProcess extends Model
{
    protected $fillable = [
      'process_type', 'campaign_id'
    ];
}
