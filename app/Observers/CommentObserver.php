<?php

namespace App\Observers;

use App\Models\Comment;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
class CommentObserver
{
    public function creating(Comment $comment)
    {
        $comment->content = clean($comment->content, 'repository_description');
    }

    public function created(Comment $comment)
    {
        //    $comment->repository->increment('comment_count', 1);
        $comment->repository->comment_count = $comment->repository->comments()->count();

        $comment->repository->save();
    }
}