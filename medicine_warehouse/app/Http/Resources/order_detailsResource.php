<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use app\Http\Resources\Company_of_MedicineResource;

class order_detailsResource extends ResourceCollection
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
            'medicine_id' => $this->scientific_name,
            'order_id' => $this->trade_name,
            'status' => $this->available_quantity,
            'quantity' => $this->expiry_date,
            'price' => $this->price,
            'company_name'=> Company_of_MedicineResource::make($this->company_name),

        ];
    }
}
