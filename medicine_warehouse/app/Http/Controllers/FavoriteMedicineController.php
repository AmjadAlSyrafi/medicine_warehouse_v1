<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FavoriteMedicineResource;
use App\Models\FavoriteMedicine;
use App\Http\Requests\StoreFavoriteMedicineRequest;
use App\Http\Requests\UpdateFavoriteMedicineRequest;

class FavoriteMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavoriteMedicineRequest $request)
    {
        $user = Auth::user();
        $medicineId = $request->input('medicine_id');

        // Check if the medicine is already a favorite
        $existingFavorite = $user->favoriteMedicines->where('medicine_id', $medicineId)->first();


        if ($existingFavorite) {
            // If it's already a favorite, remove it
            $existingFavorite->delete();

            return response()->json(['message' => 'Medicine removed from favorites.',
                                    'is_favorite' => "false",
        ], 201);
        }

         else {
            // If it's not a favorite, add it
            $favoriteMedicine = new FavoriteMedicine([
                'user_id' => $user->id,
                'medicine_id' => $medicineId,
            ]);

            $favoriteMedicine->save();

            return response()->json(['message' => 'Medicine added to the favorites',
                                    'is_favorite' => "true",
        ],201);
        }
}


    /**
     * Display the specified resource.
     */
    public function show(FavoriteMedicine $favoriteMedicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteMedicine $favoriteMedicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteMedicineRequest $request, FavoriteMedicine $favoriteMedicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteMedicine $favoriteMedicine)
    {
        //
    }
}
