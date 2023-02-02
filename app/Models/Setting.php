<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about_app','accounts', 'app_comission', 'fb_link', 'insta_link', 'tw_link', 'phone');
    // protected $casts = [
    //     'accounts' => 'array', // Will convarted to (Array)
    // ];
    // protected function accounts(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }

    public function getAccountsAttribute($val){
        return json_decode($val,true);
    }
    public function setAccountsAttribute($val){
        $this->attributes['accounts'] = json_encode($val);
    }


}