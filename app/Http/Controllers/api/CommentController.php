<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function commentPost(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'body' => 'required',
            'description' => 'required',
        ]);

        $comment = Comments::create([
            'post_id' => $request->post_id,
            'body' => $request->body,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        $comment->load('user', 'post');

        return response()->json($comment, 201);
    }
}
