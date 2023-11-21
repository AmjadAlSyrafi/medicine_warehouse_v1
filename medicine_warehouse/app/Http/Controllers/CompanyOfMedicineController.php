<?php

namespace App\Http\Controllers;

use App\Models\Company_of_Medicine;
use App\Http\Requests\StoreCompany_of_MedicineRequest;
use App\Http\Requests\UpdateCompany_of_MedicineRequest;

class CompanyOfMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
    public function store(StoreCompany_of_MedicineRequest $request)
    {
        return new Company_nameResource( Company_of_Medicine::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Company_of_Medicine $company_of_Medicine)
    {
        if (!$company_of_Medicine) {
            return response()->json(['error' => 'The Order not found'], 404);
        }
        return new Company_nameResource( $company_of_Medicine );
    }

    /**
     * return new Company_nameResource( $medicine );
     * Show the form for editing the specified resource.
     */
    public function edit(Company_of_Medicine $company_of_Medicine)
    {
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompany_of_MedicineRequest $request, Company_of_Medicine $company_of_Medicine)
    {
        $company_name-> update($request->all());

        return response()->json(['company_of_Medicine' => $company_name], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company_of_Medicine $company_of_Medicine)
    {
        if (!$company_of_Medicine) {
            return response()->json(['error' => 'Company_of_Medicine not found'], 404);
        }

        $company_of_Medicine->delete();

        return response()->json(['message' => 'Company_of_Medicine deleted successfully'], 200);
    }
}
