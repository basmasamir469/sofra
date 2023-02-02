<?php

namespace App\Http\Controllers\Api\resturant;

use App\Models\Order;
use Illuminate\Http\Request;
use App\constants\OrderStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\NotificationCollection;

class OrderController extends Controller
{
    //
    public function NewOrders(){
        $resturant=auth('api-resturants')->user();
        $new_orders=$resturant->orders()->where('status',OrderStatus::Order_pending)->paginate(10);
        if(count($new_orders) > 0){
            return responseJson(1,'New Orders',$new_orders);
        }
        return responseJson('1','no orders');


    }

    public function OrderActions(Request $request){
         if ($request->has('accept')){
              $order=Order::findOrFail($request->order_id);
              DB::beginTransaction();
              if($order->update(['status'=>OrderStatus::Order_accepted])){
                $notification=$order->client->notifications()->create([
                    'order_id'=>$order->id,
                    'title'=>'Your order is accepted :)!',
                    'content'=>'your order will be ready in '.$order->meals()->sum('preparation_time').'minutes',
         
                     ]);
                 $tokens=$order->client->tokenss()->pluck('token')->toArray();
                    if($tokens){
                    $title=$notification->title;
                    $body=$notification->content;
                    $data=[
                        'order_id'=>$order->id
                    ];
                    $send=notifyByFirebase($title,$body,$tokens,$data);
                    DB::commit();
                    return responseJson(1,'order is accepted',$order);
                    }
         
              };
              
         }
         if ($request->has('reject')){
            $order=Order::findOrFail($request->order_id);
            DB::beginTransaction();
            if($order->update(['status'=>OrderStatus::Order_rejected])){
              $notification=$order->client->notifications()->create([
                'order_id'=>$order->id,
                'title'=>'Your order is rejected :(',
                'content'=>'sorry for rejecting your order please try again another time we will wait you',
     
                 ]);
             $tokens=$order->client->tokenss()->pluck('token')->toArray();
                if($tokens){
                $title=$notification->title;
                $body=$notification->content;
                $data=[
                    'order_id'=>$order->id
                ];
                $send=notifyByFirebase($title,$body,$tokens,$data);
                DB::commit();
                return responseJson(1,'order is rejected',$order);
                }

            };
            
       }

    }


    public function CurrentOrders(){
        $resturant=auth('api-resturants')->user();
        $current_orders=$resturant->orders()->where('status',OrderStatus::Order_accepted)->paginate(10);
        if(count($current_orders) > 0){
            return responseJson(1,'current Orders',$current_orders);
        }
        return responseJson('1','no orders');

    }

   public function ConfirmOrder(Request $request){

    if ($request->has('confirm')){
        $order=Order::findOrFail($request->order_id);
        if($order->status != OrderStatus::Order_accepted){
            return responseJson(0,'error');
        }
        DB::beginTransaction();
        if($order->update(['status'=>OrderStatus::Order_delivered])){
          $notification=$order->client->notifications()->create([
            'order_id'=>$order->id,
            'title'=>'Your order is delivered :)',
            'content'=>'Enjoy your meal',
 
             ]);
         $tokens=$order->client->tokenss()->pluck('token')->toArray();
            if($tokens){
            $title=$notification->title;
            $body=$notification->content;
            $data=[
                'order_id'=>$order->id
            ];
            $send=notifyByFirebase($title,$body,$tokens,$data);
            DB::commit();
            return responseJson(1,'order is delivered',$order);
            }

        };
        
   }

   }

   public function PreviousOrders(){
    $resturant=auth('api-resturants')->user();
    $previous_orders=$resturant->orders()->whereIn('status',[OrderStatus::Order_rejected,OrderStatus::Order_delivered,OrderStatus::Order_cancelled])->paginate(10);
    if(count($previous_orders) > 0){
        return responseJson(1,'previous Orders',$previous_orders);
    }
    return responseJson('1','no orders');

   }

   public function notifications(){

    $resturant=auth('api-resturants')->user();
    return responseJson(1,'my notifications',new NotificationCollection($resturant->notifications));

}


}
