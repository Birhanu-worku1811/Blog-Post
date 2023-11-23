<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use App\Models\Comment;
use App\Http\Resources\Comment as CommentResource;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'delete', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BlogPost $post, Request $request)
    {
        $perPage = $request->input('per_page')??15;
        return CommentResource::collection(
            $post->comments()
                ->with('user')
                ->paginate($perPage))
            ->appends([
                'per_page' => $perPage
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);
        event(new CommentPosted($comment));

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $post, Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPost $post, Comment $comment, StoreComment $request)
    {
        $this->authorize($comment);
        $comment->content = $request->input('content');
        $comment->save();

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $post, Comment $comment)
    {
        $this->authorize($comment);
        $comment->delete();

        return response()->noContent();
    }
}
