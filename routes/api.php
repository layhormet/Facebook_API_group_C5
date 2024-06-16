<?php
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');

//upload images
Route::get('/image/list', [ImageController::class, 'index'])->name('image_list');
Route::post('/image/create', [ImageController::class, 'store'])->name('image_create');

// profile router
Route::post('/profile/create', [ProfileController::class, 'store'])->name('profile_create');
Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile_show');
Route::get('/profile/list', [ProfileController::class, 'index'])->name('profile_list');
Route::put('/profile/update/{id}',[ProfileController::class,'update'])->name('profile_update');

//user
Route::post('/user/create', [UserController::class, 'store'])->name('user_create');
Route::get('/user/list', [UserController::class, 'index'])->name('user_list');
Route::put('/user/update/{id}',[UserController::class,'update'])->name('user_update');

