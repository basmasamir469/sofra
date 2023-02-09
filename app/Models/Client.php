<?php

namespace App\Models;

use App\Models\Token;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Client extends Model 
{
    use HasApiTokens;
    protected $table = 'clients';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'phone', 'email', 'password', 'district_id');
    protected $hidden = array('password','pin_code');

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function tokenss()
    {
        return $this->morphMany(Token::class, 'tokennable');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notificationable');
    }



}