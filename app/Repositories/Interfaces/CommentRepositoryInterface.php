<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface
{
    public function getCommentsOnBlog($blogId);
    public function addComment($validated);



}
