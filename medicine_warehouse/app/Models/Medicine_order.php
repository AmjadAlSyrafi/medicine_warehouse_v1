<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine_order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_price',
        'payment_status',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(user::class);
    }

    // A medicine order has many medicines through the user

    public function orderDetails()
    {
        return $this->hasMany(order_details::class);
    }
}
