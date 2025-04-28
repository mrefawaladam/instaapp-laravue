<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Repositories\PostRepository;
use App\Services\PostService;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(PostRepository $postRepository)
    {
        $userId = auth()->id();
        $posts = $postRepository->getAllPostsWithRelations();

        return Inertia::render('Feed', [
            'posts' => $posts->map(function ($post) use ($userId) {
                return [
                    'id' => $post->id,
                    'user' => $post->user,
                    'image_url' => $post->image_url,
                    'caption' => $post->caption,
                    'created_at' => $post->created_at,
                    'like_count' => $post->like_count,
                    'liked' => $post->likes->contains('user_id', $userId),
                    'comments' => $post->comments->map(function ($comment) {
                        return [
                            'id' => $comment->id,
                            'user' => $comment->user->name,
                            'comment' => $comment->comment,
                            'created_at' => $comment->created_at,
                        ];
                    }),
                ];
            }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(StorePostRequest $request)
    {
        $path = $this->postService->uploadImage($request->file('image'));
        $this->postService->createPost(Auth::id(), $path, $request->caption);

        return redirect()->route('feed')->with('success', 'Post created successfully!');
    }

    public function like(Post $post)
    {
        $liked = $this->postService->toggleLike($post, Auth::id());

        return response()->json([
            'liked' => $liked,
            'like_count' => $post->like_count,
        ]);
    }

    public function addComment(StoreCommentRequest $request, Post $post)
    {
        $comment = $this->postService->addComment($post, Auth::id(), $request->comment);

        return response()->json([
            'id' => $comment->id,
            'user' => $comment->user->name,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at,
        ]);
    }

    public function updateComment(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $updatedComment = $this->postService->updateComment($comment, $request->comment);

        return response()->json([
            'message' => 'Comment updated successfully.',
            'comment' => $updatedComment->comment,
        ]);
    }

    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $this->postService->deleteComment($comment);

        return response()->json([
            'message' => 'Comment deleted successfully.',
        ]);
    }
}
