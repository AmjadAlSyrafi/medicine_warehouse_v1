<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MedicineController;

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

Route::middleware(['auth:sanctum' , 'role:admin'])->group(function () {
    Route::apiResource('medicines', MedicineController::class);

});
