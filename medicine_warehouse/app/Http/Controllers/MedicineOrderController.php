<?php

namespace App\Http\Controllers;

use App\Models\Medicine_order;
use App\Http\Requests\StoreMedicine_orderRequest;
use App\Http\Requests\UpdateMedicine_orderRequest;

class MedicineOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $medicine_order = Medicine_order::query();

        if ($request->has("IncludeOrder_details")) {
            $medicine_order->with("Order_details");
        }

        $perPage = $request->input('per_page' , 5);
        $medicines_orders = $medicine_order->paginate($perPage);

         return new Medicine_OrderCollection($medicines_orders);
        
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
    public function store(StoreMedicine_orderRequest $request)
    {
        return new Medicine_orderResource( Medicine_order::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine_order $medicine_order)
    {
        if (!$medicine_order) {
            return response()->json(['error' => 'The Order not found'], 404);
        }

        return new Medicine_orderResource( $medicine_order );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine_order $medicine_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicine_orderRequest $request, Medicine_order $medicine_order)
    {
        $medicine_order-> update($request->all());

        return response()->json(['medicine_order' => $medicine_order], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine_order $medicine_order)
    {
        if (!$medicine_order) {
            return response()->json(['error' => 'The Medicine Order not found'], 404);
        }

        $medicine_order->delete();

        return response()->json(['message' => 'Medicine Order deleted successfully'], 200);
    }
}
