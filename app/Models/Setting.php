<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about_app', 'app_comission', 'fb_link', 'insta_link', 'tw_link', 'phone');

}