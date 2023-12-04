<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Repo\Functions;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\MedicineCollection;
use App\Models\Classification;
use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;
use Illuminate\Http\Request;
use app\Http\Resources\ClassificationCollection;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;


class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classification = Classification::query();

        if($request->has("IncludeMedicine")){
            $classification->with("Medicine");
        }

        $perPage = $request->input('per_page' , 6);
        $classifications = $classification->paginate($perPage);

         return new ClassificationCollection($classifications);
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
    public function store(StoreClassificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Classification $classification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classification $classification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassificationRequest $request, Classification $classification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classification $classification)
    {
        //
    }

    public function search(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        try {
            $this->validate($request, [
                'tradeName' => 'nullable|string|max:255',
                'classification' => 'nullable|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }

        $medicinesQuery = Medicine::query();

        if ($request->has('tradeName')) {
            $searchTerm = $request->query('tradeName');
            $medicines =$medicinesQuery->where('trade_name', 'LIKE', '%' . $searchTerm . '%')->get();
                if ($medicines->isEmpty()) {
                    return response()->json([
                        'result' => false,
                        'error' => 'Select an existing item'], 404);
                }
        }


        if ($request->has('classification')) {
            // Retrieve medicines based on the specified classification name
            $classificationName = $request->input('classification');
            $classification = Classification::where('name', $classificationName)->first();

            if ($classification) {
                $medicinesQuery->whereHas('classification', function ($query) use ($classification) {
                    $query->where('id', $classification->id);
                });

            }   else {
                // Handle case where classification is not found
                    return response()->json([
                        'result' => false,
                        'error' => 'Select an exsisting item'], 404);
            }
        }
        $medicines = $medicinesQuery->get();
        $medicines = Functions::makeFavorite($medicines);
        return response()->json([
            'result' => true,
            'message' => 'application medicine page',
            'data' => [
                new MedicineCollection($medicines)
            ],

        ], 200);

    }

}
