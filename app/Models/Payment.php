<?php

namespace App\Models;

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

}