<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('notificationable_id', 'notificationable_type', 'order_id', 'title', 'content');
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function notificationable()
    {
        return $this->morphTo();
    }


}