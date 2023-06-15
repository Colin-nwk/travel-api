<?php

use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('travels', [TravelController::class, 'index']);
Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);


Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Route::resource('travels', Admin\TravelController::class);
    Route::post('travels', [Admin\TravelController::class, 'store']);
});


Route::post('login', LoginController::class);
