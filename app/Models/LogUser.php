<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogUser extends Model
{
    protected $fillable = [
        'user_id', 'login_ip', 'country','city','region'
    ];
}
