<?php

namespace App\Http\Controllers\Repo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Medicine;
class Functions {
    public static function makeFavorite($paginatedMedicines) {
        $user = Auth::user();

        $paginatedMedicines->map(function ($medicine) use ($user) {
            if ($user && $user->favoriteMedicines) {
                $hasFavorites = $user->favoriteMedicines->isNotEmpty();

                // If there are favorites, check if the medicine is a favorite
                if ($hasFavorites) {
                    $isFavorite = $user->favoriteMedicines->contains('medicine_id', $medicine->id);
                    $medicine->setAttribute('is_favorite', $isFavorite);
                }
            }

            return $medicine;
        });

        return $paginatedMedicines;
    }

}
