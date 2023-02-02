<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('address', 'payment_method', 'delivery_cost', 'total_cost', 'meals_cost', 'app_comission', 'status', 'client_id', 'resturant_id');

    public function meals()
    {
        return $this->belongsToMany('App\Models\Meal')->withPivot('quantity','price','special_order');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function getPaymentMethodAttribute($val){
        if($val==1){
            return 'Cash';
        }
        else{
            return 'Online';
        }
    }


    public function getStatusdAttribute($val){
        switch ($val) {
            case 0:
                # code...
                return 'Cancelled';
                break;
            case 1:
                return 'Pending';
                break;
            case 2:
                return 'Accepted';
                break;
            case 3:
                return 'Rejected';
                break;
            case 4:
                return 'Delivered';
                break;
    
        }
    }


}