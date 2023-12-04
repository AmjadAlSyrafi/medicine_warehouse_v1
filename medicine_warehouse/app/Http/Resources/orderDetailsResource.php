<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MedicineResource;

class orderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       $a =  MedicineResource::make($this->medicine)->toArray($request);
       unset($a['is_favorite']);
       
        return [

            'id' => $this->id,
            'order_id' => $this->order_id,
            'medicine' => $a,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}
