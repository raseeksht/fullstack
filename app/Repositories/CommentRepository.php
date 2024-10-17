<?php

namespace App\Repositories;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Auth;
use DB;

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
        // $comment = Comment::create([
        //     'user_id' => $validated['user_id'],
        //     'blog_id' => $validated['blog_id'],
        //     'commentContent' => $validated['commentContent'],
        //     'parent' => $validated['parent'] ?? null // ?? -> null coale0cing operator
        // ]);

        // equivalent query builder

        $comment = DB::table('comments')
            ->insert([
                'user_id' => $validated['user_id'],
                'blog_id' => $validated['blog_id'],
                'commentContent' => $validated['commentContent'],
                'parent' => $validated['parent'] ?? null,// ?? -> null coale0cing operator
                'created_at' => now(),
                'updated_at' => now()
            ]);

        return $comment;
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::destroy($commentId);

        // equivalent query builder
        // $comment = DB::table('comments')
        //     ->where('id', $commentId)
        //     ->delete();

        //  elequent orm and query builder both returns the number of rows deleted

        return $comment;
    }

    public function updateComment($commentId, $data)
    {
        // update returns the number of rows that are effected in this case it should be 1
        // same is the returns for laravel query builder
        $updatedComment = Comment::where('id', $commentId)->update(["commentContent" => $data]);
        // equivalent query builder 
        // $updatedComment = DB::table("comments")
        //     ->where("id", $commentId)
        //     ->update(["commentContent" => $data]);
        return $updatedComment;
    }

}
