<?php

namespace App\Http\Resources;

use app\Http\Resources\order_detailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


class Medicine_orderResource extends ResourceCollection
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
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'total_price' => $this->total_price,
        ];
    }
}
