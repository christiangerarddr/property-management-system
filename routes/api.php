<?php

use App\Http\Controllers\Properties\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([
    'auth:sanctum'
])->group(function () {
    Route::resource('property', PropertyController::class);
});
