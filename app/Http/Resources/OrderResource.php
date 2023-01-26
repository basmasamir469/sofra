<?php

namespace App\Http\Resources;

use App\Http\Resources\MealCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'resturant' => $this->resturant->name,
            'created_at'=>(string)$this->created_at,
            'address'=>$this->address,
            'order_details'=>new MealCollection($this->meals),
            'meals_cost' => $this->meals_cost,
            'delivery_cost' => $this->delivery_cost,
            'total_cost'=>$this->total_cost,
            'payment_method'=>$this->payment_method
          ];

    }
}
