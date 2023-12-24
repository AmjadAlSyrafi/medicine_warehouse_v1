<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\MedicineCollection;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Repo\Functions;



class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all medicines
        $medicines = Medicine::query();

        // Get the authenticated user
        $user = Auth::user();

        // Check if "IncludeClassification" is present in the request
        if ($request->has("IncludeClassification")) {
            $medicines->with("classification");
        }

        $perPage = $request->input('per_page', 10);

        // Paginate the query before applying the map function
        $paginatedMedicines = $medicines->paginate($perPage);

        // Append is_favorite attribute to each medicine

        $paginatedMedicines = Functions::makeFavorite($paginatedMedicines);
        $paginatedMedicinesArray = $paginatedMedicines->toArray();
        // Return the JSON response
        return response()->json([
            'result' => true,
            'message' => 'application medicine page',
            'data' => [
                new  MedicineCollection($paginatedMedicines)
            ],
            'pagination' => [
                'total' => $paginatedMedicinesArray['total'],
                'per_page' => $paginatedMedicinesArray['per_page'],
                'current_page' => $paginatedMedicinesArray['current_page'],
                'last_page' => $paginatedMedicinesArray['last_page'],
                'next_page_url' => $paginatedMedicines->nextPageUrl(),
                'prev_page_url' => $paginatedMedicines->previousPageUrl(),
                'first_page_url' => $paginatedMedicines->url(1),
                'last_page_url' => $paginatedMedicines->url($paginatedMedicinesArray['last_page']),
            ],
        ], 200);

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
    public function store(StoreMedicineRequest $request)
    {
        return new MedicineResource( Medicine::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
       // $medicine = Medicine::find($medicine);

        if (!$medicine) {
            return response()->json(['error' => 'Medicine not found'], 404);
        }

        return new MedicineResource( $medicine );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicineRequest $request, Medicine $medicine)
    {
        $medicine-> update($request->all());

        return response()->json(['medicine' => $medicine], 201);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        if (!$medicine) {
            return response()->json(['error' => 'Medicine not found'], 404);
        }

        $medicine->delete();

        return response()->json(['message' => 'Medicine deleted successfully'], 200);
    }

}

