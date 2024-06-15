<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Http\Resources\PostLiatResourse;
use App\Http\Resources\PostResourse;
use App\Models\Like;
use App\Models\Post;
use App\Http\Resources\UserCommentResource; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        $posts = PostLiatResourse::collection($posts);
        return response()->json([
            'message' => "The list all posts",
            'success' => true,
            'posts' => $posts
        ]);
    }

    public function createPost(Request $request)
    {
        $request->validate([
            "content" => "required",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "video" => "required|mimes:mp4,mov,avi,wmv|max:20480",
        ]);

        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images', 'public');
            $post->image = Storage::url($image);
        }

        if ($request->hasFile('video')) {
            $video = $request->file('video')->store('videos', 'public');
            $post->video = Storage::url($video);
        }

        $post->save();

        return response()->json([
            'message' => 'Post created successfully.',
            'success' => true,
            'post' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $posts = Post::find($id);
        $posts= new PostResourse($posts);
        return response()->json(['success' => true, 'data' => $posts], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            "content" => "required",
            "image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "video" => "mimes:mp4,mov,avi,wmv|max:20480",
        ]);

        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            if ($post->image) {
                $oldImagePath = str_replace(Storage::url(''), '', $post->image);
                Storage::delete('public/' . $oldImagePath);
            }

            $image = $request->file('image')->store('images', 'public');
            $post->image = Storage::url($image);
        }

        if ($request->hasFile('video')) {
            if ($post->video) {
                $oldVideoPath = str_replace(Storage::url(''), '', $post->video);
                Storage::delete('public/' . $oldVideoPath);
            }

            $video = $request->file('video')->store('videos', 'public');
            $post->video = Storage::url($video);
        }

        $post->save();

        return response()->json([
            'message' => 'Post updated successfully.',
            'success' => true,
            'post' => $post
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.',
            'success' => true
        ]);
    }
    public function showComment($post_id)
    {
        // Find the post
        $post = Post::find($post_id);

        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        // Retrieve comments for the post with user information
        $comments = Comments::where('post_id', $post_id)->with('user')->get();
        $comments = UserCommentResource::collection($comments);

        return response()->json(['post' => $post, 'comments' => $comments], 200);
    }
    


    // add like action to post

    public function addLike(Request $request)
    {
        
        $user = $request->user();
        try {
            $like = Like::where('user_id', $user->id)
                ->where('post_id', $request->post_id)
                ->first();
                
            if ($like) {
                $like->delete();
                return response()->json([
                    "data" => true,
                    "message" => "Unlike success"
                ]);
            } else {
                $like = new Like();
                $like->user_id = $user->id;
                $like->post_id = $request->post_id;

                if ($like->save()) {
                    return response()->json([
                        "data" => true,
                        "message" => "Like add successfully"
                    ]);
                } else {
                    return response()->json([
                        "data" => false,
                        "message" => "Something went wrong"
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                "data" => false,
                "message" => "Don't have post"
            ]);
        }
    }


}
