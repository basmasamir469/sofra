<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model 
{

    protected $table = 'contacts';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('status', 'name', 'email', 'phone', 'message', 'resturant_id');

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

}