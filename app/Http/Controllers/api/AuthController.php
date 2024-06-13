<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Implementation for storing a new resource
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'success' => false
            ], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Implementation for updating the specified resource
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Implementation for removing the specified resource
    }

    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'success' => true,
            'user' => $user,
        ], 201);
    }

    /**
     * Login an existing user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
                'success' => false,
            ], 401);
        }

        $tokenResult = $user->createToken('authToken');
        $accessToken = $tokenResult->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'success' => true,
            'user' => $user,
            'access_token' => $accessToken,
        ]);
    }

    public function forgot_password(Request $request)
    {
        try {
            // Validate the email field
            $request->validate([
                'email' => 'required|string|email',
            ]);

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 404);
            }

            // Generate a random token
            $token = Str::random(40);

            // Store the token in the user's record
            $user->reset_password_token = $token;
            $user->save();

            // Generate the password reset URL
            $resetUrl = URL::to('/') . '/reset-password?token=' . $token;

            // Send email to the user with the token
            Mail::send('emails.password_reset', ['url' => $resetUrl], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Password Reset Request');
            });

            return response()->json([
                'message' => 'Password reset token generated and email sent',
                'success' => true,
            ], 200);
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            \Log::error('Error in forgot_password: ' . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
                'success' => false,
            ], 500);
        }
    }

    public function reset_password(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::where('reset_password_token', $request->token)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Invalid token',
                    'success' => false,
                ], 400);
            }

            // Update the user's password
            $user->password = Hash::make($request->password);
            $user->reset_password_token = null; // Clear the reset token
            $user->save();

            return response()->json([
                'message' => 'Password reset successfully',
                'success' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'success' => false,
            ], 500);
        }
    }
    public function logout(Request $request):JsonResponse

    {
      $user = Auth::user();
      $user->tokens()->delete();
      auth()->guard('web')->logout();
      return response()->json(['success' => true,'message' => 'you have been logged out'], 200);
    }
}
