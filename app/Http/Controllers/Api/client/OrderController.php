<?php

namespace App\Http\Controllers\Api\client;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\constants\PaymentMethod;
use App\constants\ResturantStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    //
   public function makeOrder(Request $request){
    $resturant=Resturant::find($request->resturant_id);
    if($resturant->status==ResturantStatus::Resturant_opened){
        DB::beginTransaction();
      $order=Order::create([
        'notes'=>$request->notes,
        'address'=>$request->address,
        'payment_method'=>$request->payment_method,
        'total_cost'=>0,
        'meals_cost'=>0,
        'app_comission'=>0,
        'status'=>1,
        'client_id'=>app('auth_client_id'),
        'resturant_id'=>$request->resturant_id
         ]);
        //  if($order->payment_method==PaymentMethod::PaymentMethod_cash){
        //     $order->payment_method='cash';
        //  }
        //  else{
        //     $order->payment_method='online';
        //  }
         foreach($request->meals as $m){
            $meal=Meal::find($m['id']);
            $order->meals()->attach($meal,['price'=>$meal->price_after_offer?$meal->price_after_offer:$meal->price,
                                           'quantity'=>$m['quantity'],'special_order'=>null]);
         }
         $meals_cost=0;
         foreach($order->meals as $meal){
            $meals_cost += $meal->pivot->price * $meal->pivot->quantity;
         }
         if($meals_cost >= $order->resturant->minimum_order){
         $setting=Setting::first();
        //  $meals_cost=$order->meals->pivot->sum('price');
         $delivery_cost=$order->resturant->delivery_cost;
         $total_cost=$meals_cost+$delivery_cost;
         $app_comission=$setting->app_comission * $meals_cost;
         $net=$meals_cost-$app_comission;
         $order->update([
         'meals_cost'=>$meals_cost,
         'delivery_cost'=>$delivery_cost,
         'total_cost'=>$total_cost,
         'app_comission'=>$app_comission,
         'net'=>$net
         ]);
         DB::commit();
         return responseJson(1,'order is sent successfully ',new OrderResource($order));
     }
     else{
        DB::rollback();
        return responseJson(0,'sorry minimum order is '.$resturant->minimum_order);
        // $order->delete();
     }
    }else{
        return responseJson(0,'sorry resturant is closed now please try again later');
    }
}

public function orderDetails(){

}

}
