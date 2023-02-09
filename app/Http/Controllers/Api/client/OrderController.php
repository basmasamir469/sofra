<?php

namespace App\Http\Controllers\Api\client;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Token;
use App\Models\Setting;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\constants\OrderStatus;
use App\constants\PaymentMethod;
use App\traits\NotificationTrait;
use App\constants\ResturantStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\NotificationCollection;

class OrderController extends Controller
{
    use NotificationTrait;
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
         foreach($request->meals as $m){
            $meal=Meal::find($m['id']);
            $order->meals()->attach($meal,['price'=>$meal->price_after_offer?$meal->price_after_offer:$meal->price,
                                           'quantity'=>$m['quantity'],'special_order'=>null]);
         }
         $meals_cost=0;
         foreach($order->meals as $meal){
            $meals_cost += $meal->pivot->price * $meal->pivot->quantity;
         }
         if($meals_cost < $order->resturant->minimum_order){
            DB::rollback();
            return responseJson(0,'sorry minimum order is '.$resturant->minimum_order);
            // $order->delete();    
       }
        $setting=Setting::first();
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

        $notification=$order->resturant->notifications()->create([
           'order_id'=>$order->id,
           'title'=>'New Order',
           'content'=>'there is order by '.$order->client->name.' Order Details '.json_encode(new OrderResource($order->fresh()->load('meals'))),

            ]);
        $tokens=$order->resturant->tokenss()->pluck('token')->toArray();
           if($tokens){
           $this->sendNotification($notification->title,$notification->body,$tokens,[ 'order_id'=>$order->id]);
           }
        DB::commit();
        return responseJson(1,'order is sent successfully ',new OrderResource($order->fresh()->load('meals')));

    }
    else{
        return responseJson(0,'sorry resturant is closed now please try again later');
    }
}


public function CurrentOrders(){
    $client=auth('api-clients')->user();
    $current_orders=$client->orders()->where('status',OrderStatus::Order_pending)->paginate(10);
    if(count($current_orders) > 0){
        return responseJson(1,'Current Orders',$current_orders);
    }
    return responseJson('1','no orders');


}

public function CancelOrder(Request $request){

     $order=Order::findOrFail($request->order_id);
     if($order->status != OrderStatus::Order_pending || $order->status != OrderStatus::Order_accepted){
         return responseJson(0,'error');
     }
     DB::beginTransaction();
     if($order->update(['status'=>OrderStatus::Order_cancelled])){
       $notification=$order->resturant->notifications()->create([
         'order_id'=>$order->id,
         'title'=>'order is cancelled',
         'content'=>'there is order by '.$order->client->name.' Order Details '.json_encode(new OrderResource($order->fresh()->load('meals'))),
     ]);
      $tokens=$order->resturant->tokenss()->pluck('token')->toArray();
         if($tokens){
       $this->sendNotification($notification->title,$notification->body,$tokens,[ 'order_id'=>$order->id]);
         DB::commit();
         return responseJson(1,'order is cancelled',$order);
         }
     };
     
    
    } 

    public function PreviousOrders(){
        $client=auth('api-clients')->user();
        $previous_orders=$client->orders()->whereIn('status',[OrderStatus::Order_delivered,OrderStatus::Order_cancelled])->paginate(10);
        if(count($previous_orders) > 0){
            return responseJson(1,'previous Orders',$previous_orders);
        }
        return responseJson('1','no orders');
    
    }
   
    public function notifications(){

        $clients=auth('api-clients')->user();
        return responseJson(1,'my notifications',new NotificationCollection($clients->notifications));
    
    }
    


}
