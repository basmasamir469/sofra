<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealOrder extends Model 
{

    protected $table = 'meal_order';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('order_id', 'meal_id', 'quantity', 'special_order', 'price');

}