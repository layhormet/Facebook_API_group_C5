<?php
use App\Http\Controllers\api\AuthController as ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendshipController;

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

    // Post Routes
    Route::post('/create-post', [PostController::class, 'store'])->name('createPost');
    Route::post('/add-like', [PostController::class, 'addLike'])->name('addLike');

    // Friendship Routes
    Route::post('/friend-request', [FriendshipController::class, 'sendRequest'])->name('sendFriendRequest');
    Route::post('/friend-request/{id}/accept', [FriendshipController::class, 'acceptRequest'])->name('acceptFriendRequest');
    Route::post('/friend-request/{id}/decline', [FriendshipController::class, 'declineRequest'])->name('declineFriendRequest');
    Route::delete('/remove-friends/{friend}', [FriendshipController::class, 'destroy']);
});

// Public Post Routes
Route::get('/posts', [PostController::class, 'index'])->name('listPosts');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('showPost');
Route::get('/posts/{postId}/comments', [PostController::class, 'showComment'])->name('showComment');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('updatePost');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('deletePost');
