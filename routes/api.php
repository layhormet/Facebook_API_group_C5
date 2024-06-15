<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CommentController;
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
    

    Route::post('/create-post', [PostController::class, 'store'])->name('createPost');
    Route::put('/update-post/{id}', [PostController::class, 'update'])->name('updatePost');
    Route::delete('/delete-post/{id}', [PostController::class, 'destroy'])->name('deletePost');
});

// Public routes for posts
Route::get('/posts', [PostController::class, 'index'])->name('listPosts');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('showPost');
