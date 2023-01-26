<?php
namespace App\traits;

trait ImageTrait {


    public function saveImage($photo,$path){
         $file_extentsion=$photo->getClientOriginalExtension();
         $file=time().".".$file_extentsion;
         $photo->move($path,$file);
         return $file;

    }
}