<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'scientific_name', 'trade_name', 'classification_id', 'company_name_id', 'available_quantity', 'expiry_date', 'price', 'sold', 'review',
    ];

    public function classification()
    {
        return $this->belongsTo(Classification::class , 'classification_id');
    }

    // A medicine belongs to a company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_name_id');
    }

    public function favoriteMedicines()
    {
        return $this->hasMany(FavoriteMedicine::class);
    }

}
