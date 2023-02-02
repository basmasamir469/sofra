<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model 
{

    protected $table = 'tokens';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('tokennable_id', 'tokennable_type', 'token', 'type');

    public function tokennable()
    {
        return $this->morphTo();
    }


}