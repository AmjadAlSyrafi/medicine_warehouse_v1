<?php

namespace App\Http\Controllers;

use App\Http\Resources\orderDetailsCollection;
use Illuminate\Http\Request;
use App\Models\Medicine_order;
use App\Models\Medicine;
use App\Models\Order_details;
use App\Http\Resources\Medicine_orderCollection;
use App\Http\Resources\Medicine_orderResource;
use App\Http\Requests\StoreMedicine_orderRequest;
use App\Http\Requests\UpdateMedicine_orderRequest;
use app\Http\Repositories\MedicineFunction;
use Illuminate\Support\Facades\Auth;


class MedicineOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $medicine_order = Medicine_order::query();

        if ($request->has("IncludeOrder_details")) {
            $order = $request->input("IncludeOrder_details");
            $order_details = Order_details::query()->where('order_id', $order)->get();
            //dd($order_details);

            return new orderDetailsCollection($order_details);
        }


        $perPage = $request->input('per_page' , 5);
        $medicine_order = $medicine_order->paginate($perPage);

         return new Medicine_orderCollection($medicine_order);

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



public function payment(Request $request , Auth $auth)
{
    $user = $auth::user();
    $total_price=0;

    foreach ($request->items as $item){
        $Medicine = Medicine::query()->find($item['medicine_id']);

            $total_price +=   $Medicine->price * $item['quantity'];
    }

     $order = Medicine_order::query()->create([
         'total_price'=>$total_price,
         'user_id'=>$user->id,
     ]);


     foreach ($request->items as $item){
        $Medicine = Medicine::query()->find($item['medicine_id']);

         $orderDetail = Order_details::query()->create([
             'order_id'=>$order->id,
             'medicine_id'=>$item['medicine_id'],
             'quantity'=>$item['quantity'],
             'price'=>$Medicine->price,
         ]);

     }

}

}
