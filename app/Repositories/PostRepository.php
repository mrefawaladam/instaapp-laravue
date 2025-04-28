<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function getAllPostsWithRelations()
    {
        return Post::with(['user', 'likes', 'comments.user'])->latest()->get();
    }

    public function createPost(array $data)
    {
        return Post::create($data);
    }

    public function toggleLike(Post $post, int $userId)
    {
        $like = $post->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            return false;
        } else {
            $post->likes()->create([
                'user_id' => $userId,
            ]);
            return true;
        }
    }
}
