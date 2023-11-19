<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::apiResource('medicines', MedicineController::class);

});

// Pharmacy routes
Route::middleware(['auth', 'role:pharmacy'])->group(function () {
    // Medicines
//Route::apiResource('/pharmacy/medicines', MedicineController::class);

});
