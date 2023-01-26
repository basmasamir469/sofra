<?php

function responseJson($status,$msg,$data=null){
    $response= [
     'status'=>$status,
     'message'=>$msg,
     'data'=>$data
    ];
    return response()->json($response);
 }
 