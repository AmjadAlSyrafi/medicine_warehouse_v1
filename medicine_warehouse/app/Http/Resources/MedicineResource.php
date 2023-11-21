<?php

namespace App\Http\Resources;
use App\Http\Resources\Company_of_MedicineResource;
use App\Http\Resources\ClassificationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\company_nameResource;



class MedicineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'scientificName' => $this->scientific_name,
            'tradeName' => $this->trade_name,
            'availableQuantity' => $this->available_quantity,
            'expiryDate' => $this->expiry_date,
            'price' => $this->price,
            'companyName'=> Company_of_MedicineResource::make($this->company),
            //'companyName'=>$this->company,
            'classification'=> ClassificationResource::make($this->classification)

        ];
    }
}
