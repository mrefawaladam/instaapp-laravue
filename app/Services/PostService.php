<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Repositories\PostRepository;
use App\Models\Post;
use App\Models\Comment;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function uploadImage($image)
    {
        return $image->store('posts', 'public');
    }

    public function createPost($userId, $imagePath, $caption = null)
    {
        return $this->postRepository->createPost([
            'user_id' => $userId,
            'image_url' => $imagePath,
            'caption' => $caption,
        ]);
    }

    public function toggleLike(Post $post, $userId)
    {
        return $this->postRepository->toggleLike($post, $userId);
    }

    public function addComment(Post $post, $userId, $comment)
    {
        return $post->comments()->create([
            'user_id' => $userId,
            'comment' => $comment,
        ]);
    }

    public function updateComment(Comment $comment, $newComment)
    {
        $comment->update([
            'comment' => $newComment,
        ]);
        return $comment;
    }

    public function deleteComment(Comment $comment)
    {
        return $comment->delete();
    }
}
