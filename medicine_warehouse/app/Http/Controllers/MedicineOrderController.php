<?php

namespace App\Http\Controllers;

use App\Http\Resources\orderDetailsCollection;
use Illuminate\Http\Request;
use App\Models\Medicine_order;
use App\Models\Medicine;
use App\Models\Order_details;
use App\Http\Resources\MedicineOrderCollection;
use App\Http\Resources\MedicineOrderResource;
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
    {   $user = Auth::user();
        $medicine_order = Medicine_order::query()->where('user_id',$user->id)->get();

        if ($request->has("IncludeOrder_details")) {
            $order = $request->input("IncludeOrder_details");
            $medicine_order = Medicine_order::query()->where('id',$order)->where('user_id',$user->id)->get();
            if ($medicine_order->isEmpty()) {
                return response()->json(['message' => 'NO Orders Were Found',
                                         'status'=> false], 404);
            }
            $order_details = Order_details::query()->where('order_id', $order)->get();
            return new orderDetailsCollection($order_details);
        }
        if ($medicine_order->isEmpty()) {
            return response()->json(['message' => 'NO Orders Were Found',
                                     'status'=> false], 404);
        }
             return response()->json(['message' => 'Orders Were Found',
                                 'status'=> true ,
                                 'data' => new MedicineOrderCollection($medicine_order) ], 201);
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
        //return new MedicineOrderResource( Medicine_order::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine_order $medicine_order)
    {
        if (!$medicine_order) {
            return response()->json(['error' => 'The Order not found'], 404);
        }

        return new MedicineOrderResource( $medicine_order );
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

 return response()->json(['status' => true,
                          'message' =>'order added successfully' ], 201);
}

}
