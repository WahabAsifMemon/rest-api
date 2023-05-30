<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'posts' => Post::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',

        ]);

        if ($validate->fails()) {
            return $validate->getMessageBag();
        }
        try {
            $post = new Post;
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();
            return response()->json(['message' => 'Post Created '], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try {
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();
            return response()->json(['message' => 'Post Updated '], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post Deleted'], 200);

    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        if ($keyword === null || $keyword === '') {
            return response()->json(['message' => 'Please provide a search keyword'], 200);
        }
        $query = Post::query();
        $results = $query->where('title', 'like', "%{$keyword}%")->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'No posts available'], 200);
        }

        return response()->json(['results' => $results], 200);
    }
}