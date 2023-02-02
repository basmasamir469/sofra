<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model 
{

    protected $table = 'payments';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('resturant_id', 'payment_name', 'payment_cost');

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }
    public function getCreatedAtAttribute($val){
         return Carbon::parse($val)->format('Y-m-d');
    }
    public function setCreatedAtAttribute($val){
        $this->attributes['created_at'] = Carbon::parse($val)->format('Y-m-d');
   }


}