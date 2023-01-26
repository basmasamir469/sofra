<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model 
{

    protected $table = 'reviews';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('comment', 'rate', 'client_id', 'resturant_id');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

}