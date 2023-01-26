<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('offer_name','image', 'description', 'from', 'to','resturant_id');

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

}