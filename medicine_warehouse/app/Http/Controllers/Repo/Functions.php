<?php

namespace App\Http\Controllers\Repo;

use Illuminate\Support\Facades\Auth;
use App\Models\Medicine;
use App\Http\Resources\MedicineResource;
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

    public static function get6MostSellerProducts()
    {
        $products = Medicine::query()
            ->orderBy('sold', 'DESC')->take(6)->get();
        return MedicineResource::collection($products);
    }

    public static function getMostSellerProducts()
    {
        $products = Medicine::query()
            ->orderBy('sold', 'DESC')->paginate(12);
        return MedicineResource::collection($products);
    }

    public static function get6MostVisitedProducts()
    {
        $products = Medicine::query()
            ->orderBy('review', 'DESC')->paginate(6);
        return MedicineResource::collection($products);
    }

    public static function getNewestProducts()
    {
        $products = Medicine::query()->latest()->paginate(12);
        return MedicineResource::collection($products);
    }

    public static function get6NewestProducts()
    {
        $products = Medicine::query()->latest()->take(6)->get();
        return MedicineResource::collection($products);
    }

    public static function getCheapetsProducts()
    {
        $products = Medicine::query()
            ->orderBy('price', 'ASC')->paginate(12);
        return MedicineResource::collection($products);
    }

    public static function getMostExpensivesProducts()
    {
        $products = Medicine::query()
            ->orderBy('price', 'DESC')->paginate(12);
        return MedicineResource::collection($products);
    }

}
