<?php

// use App\Http\Controllers\api\AuthController as ApiAuthController;

// use App\Http\Controllers\api\AuthController as ApiAuthController;

use App\Http\Controllers\api\AuthController as ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
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

// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/forgot-password', [AuthController::class,'sendResetLinkEmail'])->name('password.email');
Route::post('/reset_password', [AuthController::class, 'reset_password'])->name('reset_password');

// Protected routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/commentPost', [CommentController::class, 'commentPost'])->name('commentPost');
    Route::put('/updateComment/{id}', [CommentController::class, 'update'])->name('updateComment');
    Route::delete('/deleteComment/{id}', [CommentController::class, 'destroy'])->name('destroy');
    

  
});

// Public routes

// Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/forgot_password',[AuthController::class,'forgot_password'])->name('forgot_password');
// Route::post('reset_password',[AuthController::class, 'reset_password'])->name('reset_password');



Route::post('/create-post', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::get('/list', [PostController::class, 'index']);
Route::get('/show/{id}', [PostController::class, 'show']);
Route::put('/update/{id}', [PostController::class, 'update']);
Route::delete('/delete/{id}', [PostController::class, 'destroy']);
   
Route::post('/add-like', [PostController::class, 'addLike'])->middleware('auth:sanctum');



// Public routes for posts
Route::get('/posts', [PostController::class, 'index'])->name('listPosts');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('showPost');
Route::get('/posts/{postId}/comments', [PostController::class,'showComment'])->name('showComment');

