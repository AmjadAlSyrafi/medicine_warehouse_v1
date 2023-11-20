<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MedicineCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
       
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'payment_status' => $this->payment_status,
            'total_price' => $this->total_price,
            'medicine_id' => $this->medicine_id,
            'order_details'=> order_detailsResource::make($this->order_details)

        ];
    }
}
