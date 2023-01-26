<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model 
{

    protected $table = 'meals';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'price', 'price_after_offer', 'description', 'preparation_time', 'image','resturant_id');

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order')->withPivot('quantity','price','special_order');
    }
    public function resturant(){
        return $this->belongsTo('App\Models\Resturant');
    }

}