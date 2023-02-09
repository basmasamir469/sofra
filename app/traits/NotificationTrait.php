<?php
namespace App\traits;

trait NotificationTrait {


    public function sendNotification($title,$body,$tokens,$data){
        
        $send=notifyByFirebase($title,$body,$tokens,$data);
    }
}