<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\PostController;

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

// Protected routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Additional protected routes can be added here
});

// Public routes

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot_password',[AuthController::class,'forgot_password'])->name('forgot_password');
Route::post('reset_password',[AuthController::class, 'reset_password'])->name('reset_password');



Route::post('/create-post', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::get('/list', [PostController::class, 'index']);
Route::get('/show/{id}', [PostController::class, 'show']);
Route::put('/update/{id}', [PostController::class, 'update']);
Route::delete('/delete/{id}', [PostController::class, 'destroy']);
   

Route::post('/add-like', [PostController::class, 'addLike'])->middleware('auth:sanctum');



