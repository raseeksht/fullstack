<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends ApiController
{
    private $commentRepository;
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd("index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd("create");


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth()->user()->id;
        $validated['blog_id'] = (int) $validated['blog_id'];

        $newcomment = $this->commentRepository->addComment($validated);

        return $this->SuccessResponse(null, 201, "Comment Added");


    }

    /**
     * Display the specified resource.
     */
    public function show($blogId)
    {
        $comments = $this->commentRepository->getCommentsOnBlog($blogId);

        return $this->SuccessResponse($comments, 200, "Take this. comments");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        dd("edit");

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, $id)
    {
        $updated = $this->commentRepository->updateComment($id, $request->validated("commentContent"));
        // dd($request->validated());
        return $this->SuccessResponse($updated, 200, "Comment Edited");


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommentRequest $request, $id)
    {
        $validated = $request->validated();
        $comment = $this->commentRepository->deleteComment($id);

        return $this->SuccessResponse($comment, 200, "Comment Deleted");
    }
}
