<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FriendshipController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends()->get(['id', 'name', 'profile_picture_url', 'status']);

        return response()->json($friends);
    }
    public function sendRequest(Request $request)
    {
        $friend_id = $request->friend_id;
        $user = Auth::user();

        // Check if a friendship already exists
        $existingFriendship = Friendship::where(function ($query) use ($user, $friend_id) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', $friend_id);
        })->orWhere(function ($query) use ($user, $friend_id) {
            $query->where('user_id', $friend_id)
                  ->where('friend_id', $user->id);
        })->first();

        if ($existingFriendship) {
            return response()->json(['message' => 'Friend request already exists or you are already friends.'], 409);
        }

        $friendship = Friendship::create([
            'user_id' => $user->id,
            'friend_id' => $friend_id,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Friend request sent'], 200);
    }
    public function acceptRequest($friendship_id)
    {
        // Get the authenticated user's ID
        $user_id = Auth::id();
    
        // Find the friendship request where the authenticated user's ID and the friendship_id match
        $friendship = Friendship::where('friend_id', $friendship_id)
                                ->where('user_id', $user_id)
                                ->first();
    
        if ($friendship) {
            // Update the status to 'accepted'
            $friendship->update(['status' => 'accepted']);
            
            return response()->json(['data'=>$friendship,'message' => 'Friend request accepted'], 200);
        } else {
            // If no matching friendship request is found, return a 404 response
            return response()->json(['message' => 'Friend request not found'], 404);
        }
    }
    public function declineRequest($friendship_id)
    {
        // Get the authenticated user's ID
        $user_id = Auth::id();
    
        // Find the friendship request where the authenticated user's ID and the friendship_id match
        $friendship = Friendship::where('friend_id', $friendship_id)
                                ->where('user_id', $user_id)
                                ->first();
    
        if ($friendship) {
            // Update the status to 'accepted'
            $friendship->update(['status' => 'declined']);
            
            return response()->json(['data'=>$friendship,'message' => 'Friend request declined'], 200);
        } else {
            // If no matching friendship request is found, return a 404 response
            return response()->json(['message' => 'Friend request not found'], 404);
        }
    }
  
    
    

  
}
