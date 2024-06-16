<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Login success',
            'data' => $request->user(),
        ]);
    }

    public function index(): JsonResponse
    {
        $users = User::list();
        return response()->json([
            'message' => 'User list success',
            'data' => $users,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::store($request);
        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::store($request, $id);
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }
}
