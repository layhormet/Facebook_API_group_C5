<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
/**
 * @OA\Info(title="My API", version="1.0")
 */
class FriendshipController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profiles",
     *     summary="Get list of profiles",
     *     tags={"Profiles"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Profile")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     */
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
        $user_id = Auth::id();
    
    
        $friendship = Friendship::where('friend_id', $friendship_id)
                                ->where('user_id', $user_id)
                                ->first();
    
        if ($friendship) {
        
            $friendship->update(['status' => 'accepted']);
            
            return response()->json(['data'=>$friendship,'message' => 'Friend request accepted'], 200);
        } else {
        
            return response()->json(['message' => 'Friend request not found'], 404);
        }
    }
    public function declineRequest($friendship_id)
    {

        $user_id = Auth::id();
    
    
        $friendship = Friendship::where('friend_id', $friendship_id)
                                ->where('user_id', $user_id)
                                ->first();
    
        if ($friendship) {
        
            $friendship->update(['status' => 'declined']);
            
            return response()->json(['data'=>$friendship,'message' => 'Friend request declined'], 200);
        } else {
        
            return response()->json(['message' => 'Friend request not found'], 404);
        }
    }

    public function destroy($friendId)
    {
        $user = Auth::user();
        $friend = User::findOrFail($friendId);

        // Remove the friend relationship in both directions
        $user->friends()->detach($friendId);
        $friend->friends()->detach($user->id);

        return response()->json(['message' => 'Friend removed successfully']);
    }
}
