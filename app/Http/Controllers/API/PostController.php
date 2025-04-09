<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user:id,name')->get();
        
        if ($posts->isEmpty()) {
            return response()->json([
                'message' => 'No posts found',
                'data' => []
            ], 200);
        }
        
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return response()->json($post, 201);
    }

    public function show(string $id)
    {
        $post = Post::with('user:id,name')->find($id);
        
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        
        return response()->json($post);
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        
        return response()->json($post);
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);
        
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $post->delete();
        
        return response()->json(['message' => 'Post deleted successfully']);
    }
}