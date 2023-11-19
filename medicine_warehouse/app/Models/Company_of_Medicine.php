<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_of_Medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'companyName',
        // Add any other fields you may need for companies
    ];

    // Define relationships

    // A company can have many medicines
    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'company_name_id');
    }
}
