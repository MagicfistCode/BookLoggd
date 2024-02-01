<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //Adding post to database function
    public function store(Request $request)
    {
        try {
            $userId = auth()->id();

            $data = $request->validate([
                'content' => 'required',
            ]);

            $data['id'] = $userId;

            $newPost = Post::create($data);

            return back();

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function display()
    {
        // Fetch posts with user relationship, ordered by creation date (assuming there's a 'created_at' column)
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('posts'));
    }


}