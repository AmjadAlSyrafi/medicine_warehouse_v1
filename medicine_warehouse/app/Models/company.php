<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name','arabic',
        // Add any other fields you may need for companies
    ];

    // Define relationships

    // A company can have many medicines
    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'company_name_id');
    }
}
