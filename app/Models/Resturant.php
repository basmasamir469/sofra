<?php

namespace App\Models;

use App\Models\Token;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resturant extends Authenticatable
{

    protected $table = 'resturants';
    public $timestamps = true;

    use SoftDeletes,HasApiTokens;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email', 'phone', 'district_id', 'password', 'delivery_cost', 'minimum_order', 'image', 'contact_phone', 'about_us', 'status');
    protected $hidden = array('password');

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function expenses()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }

    public function tokenss()
    {
        return $this->morphMany(Token::class, 'tokennable');
    }
   
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notificationable');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }


}