<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();

        return Inertia::render('Feed', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'caption' => ['nullable', 'string'],
        ]);

        $path = $request->file('image')->store('posts', 'public');

        Post::create([
            'user_id' => Auth::id(),
            'image_url' => $path,
            'caption' => $request->caption,
        ]);

        return redirect()->route('feed')->with('success', 'Post created successfully!');
    }

    public function like(Post $post)
    {
        $user = auth()->user();
    
        $like = $post->likes()->where('user_id', $user->id)->first();
    
        if ($like) {
            // Kalau sudah like, hapus (unlike)
            $like->delete();
            $liked = false;
        } else {
            // Kalau belum like, tambahkan
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
            $liked = true;
        }
    
        return Inertia::location('/feed');
    }
    

}