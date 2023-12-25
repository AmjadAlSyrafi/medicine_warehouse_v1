<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{

    use HasFactory;
    protected $fillable = [
        'name','arabic',
        // Add any other fields you may need for classifications
    ];

    // A classification can have many medicines
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
