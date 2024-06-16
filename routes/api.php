<?php

use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;

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

// Authentication Routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/reset_password', [AuthController::class, 'reset_password'])->name('reset_password');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Comment Routes
    Route::post('/commentPost', [CommentController::class, 'commentPost'])->name('commentPost');
    Route::put('/updateComment/{id}', [CommentController::class, 'update'])->name('updateComment');
    Route::delete('/deleteComment/{id}', [CommentController::class, 'destroy'])->name('destroy');




});

// Public Post Routes
Route::get('/posts', [PostController::class, 'index'])->name('listPosts');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('showPost');
Route::get('/posts/{postId}/comments', [PostController::class, 'showComment'])->name('showComment');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('updatePost');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('deletePost');

// post 
Route::post('/create-post', [PostController::class, 'createPost'])->middleware('auth:sanctum');
Route::get('/list', [PostController::class, 'index']);
Route::get('/show/{id}', [PostController::class, 'show']);
Route::put('/update/{id}', [PostController::class, 'update']);
Route::delete('/delete/{id}', [PostController::class, 'destroy']);
   
Route::post('/add-like', [PostController::class, 'addLike'])->middleware('auth:sanctum');



//upload images
Route::get('/image/list', [ImageController::class, 'index'])->name('image_list');
Route::post('/image/create', [ImageController::class, 'store'])->name('image_create');

// profile router
Route::post('/profile/create', [ProfileController::class, 'store'])->name('profile_create');
Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile_show');
Route::get('/profile/list', [ProfileController::class, 'index'])->name('profile_list');
Route::put('/profile/update/{id}',[ProfileController::class,'update'])->name('profile_update');


