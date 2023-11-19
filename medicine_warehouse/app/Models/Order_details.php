<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'price',
        'status',


    ];

    public function order()
    {
        return $this->belongsTo(Medicine_order::class);
    }

    public function medicines()
    {
        return $this->hasManyThrough(Medicine::class, user::class);
    }
}
