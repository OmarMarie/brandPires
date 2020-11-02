<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Cache;

class Player extends Authenticatable
{
    use HasApiTokens, Notifiable,SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token', 'is_online', 'deleted_at', 'last_activity'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function level()
    {
        return $this->belongsTo(Levels::class, 'level_id');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}
