<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
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
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.',
            'success' => true
        ]);
    }
}
