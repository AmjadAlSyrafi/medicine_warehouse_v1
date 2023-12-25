<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\FavoriteMedicineController;
use App\Http\Controllers\MedicineOrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClassificationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//user signin /signup
Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);

//User Logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [UserController::class, 'logoutUser']);
});

 //admin Role Api
Route::middleware(['auth:sanctum' , 'role:admin' , 'checkSanctumToken'])->group(function () {
    //get the order
    Route::get('/order' , [MedicineOrderController::class , 'orderForAdmin']);
    //update the payment status & update the status
    Route::patch('/order/{medicine}' , [MedicineOrderController::class , 'put']);
    //CRUD for Medicine
    Route::apiResource('/medicines', MedicineController::class);
    //search for Medicin and filtering
    Route::get('/search',[ClassificationController::class , 'search']);
    //CRUD for company name
    Route::apiResource('/company', CompanyController::class);
    //CRUD for classification
    Route::apiResource('/classifications', ClassificationController::class);
});

//----------------------------------------------------------------------------------------------

//pharmacy Role Api

Route::middleware(['auth:sanctum' , 'role:pharmacy' , 'checkSanctumToken'])->prefix('pharmacy')->group(function () {
    //make order
    Route::post('/addorder' , [MedicineOrderController::class, 'payment' ]);
    //get the order || ?IncludeOrder_details={order_id} ex:  /order?IncludeOrder_details=2
    Route::get('/order' , [MedicineOrderController::class , 'index']);
    //..........The home page.........
    //View the medicines
    Route::get('/medicines' , [MedicineController::class , 'index']);
    //get the medicine by the id
    Route::get('/medicine/{medicine}' , [MedicineController::class , 'view']);
    //search for Medicin and filtering
    Route::get('/search',[ClassificationController::class , 'search']);
    //make the medicine favorite /unfavorite
    Route::post('/favorite-medicines', [FavoriteMedicineController::class, 'store']);
});
