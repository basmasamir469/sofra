<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model 
{

    protected $table = 'cities';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name');

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }

    public function resturants()
    {
        return $this->hasMany('App\Models\Resturant');
    }

}