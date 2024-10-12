<?php

use App\Http\Controllers\Properties\PropertyController;
use App\Http\Controllers\Properties\PropertyFiltersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    //TODO:: Dashboard Controller
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('property', PropertyController::class);
    Route::get('properties', [PropertyController::class, 'listProperties'])->name('properties.list');

    Route::post('property/filter', [PropertyFiltersController::class, 'filterProperty'])->name('property.filter');
});
