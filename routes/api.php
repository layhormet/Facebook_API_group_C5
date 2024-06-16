<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Friendship;
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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"Authentication"},
 *     summary="Register a new user",
 *     operationId="register",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/RegisterResponse")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::post('/register', [AuthController::class, 'register'])->name('register');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::post('/login', [AuthController::class, 'login'])->name('login');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::post('/forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::post('/reset_password', [AuthController::class, 'reset_password'])->name('reset_password');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */

Route::middleware('auth:sanctum')->group(function () {
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    // Comment Routes
    Route::post('/commentPost', [CommentController::class, 'commentPost'])->name('commentPost');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::put('/updateComment/{id}', [CommentController::class, 'update'])->name('updateComment');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::delete('/deleteComment/{id}', [CommentController::class, 'destroy'])->name('destroy');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::get('/friend_list', [FriendshipController::class, 'index']);
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    // Post Routes
    Route::post('/create-post', [PostController::class, 'store'])->name('createPost');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::post('/add-like', [PostController::class, 'addLike'])->name('addLike');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */

    // Friendship Routes
    Route::post('/friend-request', [FriendshipController::class, 'sendRequest'])->name('sendFriendRequest');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::post('/friend-request/{id}/accept', [FriendshipController::class, 'acceptRequest'])->name('acceptFriendRequest');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::post('/friend-request/{id}/decline', [FriendshipController::class, 'declineRequest'])->name('declineFriendRequest');
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
    Route::delete('/remove-friends/{friend}', [FriendshipController::class, 'destroy']);
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
});

// Public Post Routes
Route::get('/posts', [PostController::class, 'index'])->name('listPosts');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::get('/posts/{id}', [PostController::class, 'show'])->name('showPost');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::get('/posts/{postId}/comments', [PostController::class, 'showComment'])->name('showComment');

/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */

Route::put('/posts/{id}', [PostController::class, 'update'])->name('updatePost');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('deletePost');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */

// post 
Route::post('/create-post', [PostController::class, 'createPost'])->middleware('auth:sanctum');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::get('/list', [PostController::class, 'index']);
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::get('/show/{id}', [PostController::class, 'show']);
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::put('/update/{id}', [PostController::class, 'update']);
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::delete('/delete/{id}', [PostController::class, 'destroy']);
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::post('/add-like', [PostController::class, 'addLike'])->middleware('auth:sanctum');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */



//upload images
Route::get('/image/list', [ImageController::class, 'index'])->name('image_list');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::post('/image/create', [ImageController::class, 'store'])->name('image_create');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */

// profile router
Route::post('/profile/create', [ProfileController::class, 'store'])->name('profile_create');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile_show');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::get('/profile/list', [ProfileController::class, 'index'])->name('profile_list');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile_update');
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login an existing user",
 *     operationId="login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/LoginResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
