<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bubbles extends Model
{
    protected $fillable =[
      'bubble_type', 'bubble_content', 'bubble_weight',"gift_id","campaign_id"
    ];
}
