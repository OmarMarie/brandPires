<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
}
