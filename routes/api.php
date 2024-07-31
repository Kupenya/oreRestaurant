<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Controller;



// Authentication Routes
Route::post('register/customer', [AuthController::class, 'registerCustomer']);
Route::post('register/staff', [AuthController::class, 'registerStaff']);
Route::post('login', [AuthController::class, 'login']); // User login

// Profile Route - Accessible by authenticated users
Route::middleware('auth:api')->group(function() {
    Route::get('profile', [AuthController::class, 'profile']); 
});

// Staff Routes - Only accessible by staff members
Route::middleware(['auth:api', 'role:staff'])->group(function() {
    Route::post('/menus', [MenuController::class, 'store']); 
    Route::put('/menus/{id}', [MenuController::class, 'update']); 
    Route::delete('/menus/{id}', [MenuController::class, 'destroy']); 
    Route::get('/users', [Controller::class, 'index']);
    Route::get('/users/{id}', [Controller::class, 'show']);});
    Route::get('/orders', [OrderController::class, 'index']); 
    Route::get('/orders/{id}', [OrderController::class, 'show']); 
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);


// Public Menu Routes - Accessible by everyone (no authentication required)
Route::get('/menus', [MenuController::class, 'index']); 
Route::get('/menus/{id}', [MenuController::class, 'show']); 
Route::get('/menus/list/discounted', [MenuController::class, 'discounted']); 
Route::get('/menus/category/{category}', [MenuController::class, 'byCategory']); 

// er Order Routes - Enforced by operational hours and accessible only by authenticated users-customer
Route::middleware(['auth:api', 'role:customer', 'operational_hours'])->group(function() {
    Route::post('/orders', [OrderController::class, 'store']); 
});