<?php

namespace App\Repositories;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Auth;

class CommentRepository implements CommentRepositoryInterface
{
    public function getCommentsOnBlog($blogId, $parent = null)
    {
        $result = [];

        // Fetch the comments with the specified blog ID and parent (or null)
        $comments = Comment::where('blog_id', $blogId)
            ->where('parent', $parent)  // Use $parent to get replies
            ->latest()
            ->get();

        foreach ($comments as $comment)
        {
            // Create an associative array with the comment and its replies
            $replies_arr = [
                'comment' => $comment,
                'replies' => $this->getCommentsOnBlog($blogId, $comment->id)  // Recursively get replies
            ];

            // Append to the result array
            $result[] = $replies_arr;
        }

        return $result;
    }

    public function addComment($validated)
    {
        // dd($validated);
        $comment = Comment::create(['user_id' => $validated['user_id'], 'blog_id' => $validated['blog_id'], 'commentContent' => $validated['commentContent'], 'parent' => isset($validated['parent']) ? $validated['parent'] : null]);
        return $comment;
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::destroy($commentId);
        return $comment;
    }

    public function updateComment($commentId, $data)
    {
        $updatedComment = Comment::where('id', $commentId)->update(["commentContent" => $data]);
        return $updatedComment;
    }

}