<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(CommentRequest $request, Comment $comment)
    {
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->repository_id = $request->repository_id;
        $comment->save();

        return back()->with('success', '评论创建成功！');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('destroy', $comment);

        $comment->delete();

        return back()->with('success', '评论删除成功！');

    }
}
