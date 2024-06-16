<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * @OA\Info(title="My API", version="1.0")
 */
class CommentController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // You can implement the method if needed
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // You can implement the method if needed
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);
        $comment = Comments::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->description = $request->description;
        $comment->save();
        $comment->load('user', 'post');
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comments::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $comment->delete();
        return response()->json(['success' => true, 'message' => 'Comment removed']);
    }

    /**
     * Store a newly created comment on a post.
     */
    public function commentPost(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'description' => 'required|string|max:255',
        ]);

        $comment = Comments::create([
            'post_id' => $request->post_id,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        $comment->load('user', 'post');

        return response()->json($comment, 201);
    }
}
