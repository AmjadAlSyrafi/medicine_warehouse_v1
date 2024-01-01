<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FavoriteMedicineResource;
use App\Models\FavoriteMedicine;
use Illuminate\Http\Request;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\MedicineCollection;
use App\Http\Requests\StoreFavoriteMedicineRequest;
use App\Http\Requests\UpdateFavoriteMedicineRequest;
use App\Http\Controllers\Repo\Functions;

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

    public function search(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Search for the favorite medicine by medicine ID and user ID
        $favoriteMedicine = FavoriteMedicine::where('medicine_id', $request->input('medicine_id'))
            ->where('user_id', $user->id)
            ->first();

        if ($favoriteMedicine) {
            return response()->json([
                'status' => true,
                'message' => 'Favorite medicine found',
                'favorite_medicine' => new MedicineResource($favoriteMedicine->medicine),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Favorite medicine not found',
            ], 404);
        }
    }

    public function getFavoriteMedicines(Request $request)
{
    // Get the authenticated user
    $user = auth()->user();
    $favoriteMedicines =
    $favoriteMedicines = FavoriteMedicine::where('user_id', $user->id);
    // Retrieve the favorite medicines for the user
    $favoriteMedicines = $user->favoriteMedicines;
    // Extract medicine models from the favorite records
    $medicines = $favoriteMedicines->map(function ($favorite) {
        return $favorite->medicine;
    });
    $medicines = Functions::makeFavorite($medicines);
    return response()->json([
        'status' => true,
        'message' => 'Favorite medicines retrieved successfully',
        'favorite_medicines' => new MedicineCollection($medicines),
    ], 200);
}

}
