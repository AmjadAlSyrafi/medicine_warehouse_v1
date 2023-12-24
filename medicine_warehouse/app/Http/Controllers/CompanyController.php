<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyCollection;
use App\Http\Requests\StorecompanyRequest;
use App\Http\Requests\UpdatecompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = company::all();
        return new CompanyCollection($company);
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
    public function store(StorecompanyRequest $request)
    {
        return new CompanyResource( Company::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(company $company)
    {
        if (!$company) {
            return response()->json(['error' => 'The Company not found'], 404);
        }
        return new CompanyResource($company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecompanyRequest $request, company $company)
    {
        $company-> update($request->all());
        $a = new CompanyResource($company);
        return response()->json(['company_of_Medicine' => $a], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(company $company)
    {
        if (!$company) {
            return response()->json(['error' => 'Company_of_Medicine not found'], 404);
        }

        $company->delete();

        return response()->json(['message' => 'Company_of_Medicine deleted successfully'], 200);
    }
}
