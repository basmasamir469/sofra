<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResturantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'delivery_cost'=>$this->delivery_cost,
            'minimum_order'=>$this->minimum_order,
            'status' => $this->status,
            'district' => $this->district->name,
            'city' => $this->district->city->name,
          ];
    
    }
}
