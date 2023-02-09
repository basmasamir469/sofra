<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Category;
use App\Models\District;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\constants\ResturantStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResturantResource;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    //
    public function cities(){
        $cities=City::all();
        return responseJson(1,'success',$cities);
    }

    public function storeCity(Request $request){
        $city=City::create([
            'name'=>$request->name
        ]);
        return responseJson(1,'success',$city);
    }

    public function resturants(){
        $resturants=Resturant::all();
        return responseJson(1,'success',$resturants);
    }

    public function districts(Request $request){
        $districts=District::all();
        if($request->has('city_id')){
            $districts=District::whereHas('city',function($q) use($request){
                  return $q->where('id',$request->city_id);
            })->get();
        }
        return responseJson(1,'success',$districts);
    }

    public function storeDistrict(Request $request){
        $district=District::create([
            'name'=>$request->name,
            'city_id'=>$request->city_id
        ]);
        return responseJson(1,'success',$district);
    }

    public function searchResturants(Request $request){
        $resturants=Resturant::query();
        $resturants=$resturants->when($request->has('resturant_id'),function($q) use($request){
                     return $q->where('id',$request->resturant_id);
        })->when($request->has('city_id'),function($q) use($request){
            return $q->whereHas('district',function($q) use($request){
                return $q->where('city_id',$request->city_id);
           });
        })->get();
        if(count($resturants)>0){
        return responseJson(1,'success',$resturants);
        }
        else{
            return responseJson(1,'no results',$resturants);

        }
        }

        public function categories(){
            $categories=Category::all();
            return responseJson(1,'success',$categories);
        }

        public function storeCategory(Request $request){
            $category=Category::create([
                'name'=>$request->name,
            ]);
            return responseJson(1,'success',$category);
        }
    
        public function settings(){
            $settings=Setting::firstOrFail();
            return responseJson(1,'success',$settings);
        }

        public function contactus(Request $request){
            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'message'=>'required',
                'status'=>'required|in:suggestion,complaint,enquiry'
            ]);
            if($validator->fails()){
                return responseJson(0,$validator->errors()->first(),$validator->errors());
            }
            
            $contact=Contact::create($request->all());
            return responseJson(1,'message is sent successfully',$contact);
        }

        public function resturant($id){
            $resturant=Resturant::findOrFail($id);
            if($resturant->status==ResturantStatus::Resturant_opened){
                $resturant->status='opened';
           }
           else{
                $resturant->status='closed';
           }
            return responseJson(1,'success',new ResturantResource($resturant));
        }
        public function resturantComissions(){
            $settings=Setting::first();
            $resturant=auth('api-resturants')->user();
            $sales=$resturant->orders->sum('meals_cost');
            $app_comission=$resturant->orders->sum('app_comission');
            $paid=0;
            $remaining=$app_comission-$paid;
            $settings->update(['accounts'=>['bank-alahli'=>29383829292,'bank-masr'=>28382829293]]);
            return responseJson(1,'success',['settings'=>$settings,'sales'=>$sales,
            'app_comission'=>$app_comission,
            'paid'=>$paid,
            'remaining'=>$remaining]);

        }
}
