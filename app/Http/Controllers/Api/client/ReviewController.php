<?php

namespace App\Http\Controllers\Api\client;

use App\Models\Review;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    //
 
    public function index($id){
        $resturant=Resturant::findOrFail($id);

        $reviews=Review::where('resturant_id',$resturant->id)->paginate(10);
        if(count($reviews)>0){
            return responseJson(1,'success',$reviews);
        }
        else{
            return responseJson(1,'no reviews',$reviews);
        }

        
    }

    public function store(Request $request,$id){
        $resturant=Resturant::findOrFail($id);
        $request->merge(['client_id'=>app('auth_client_id')]);
        $review=$resturant->reviews()->create($request->all());
        if(!$review){
            return responseJson(0,'faild to send your review please try again');
        }
        return responseJson(1,'your review is sent successfully',$review);

    }
}
