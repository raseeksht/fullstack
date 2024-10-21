<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BlogController extends ApiController
{
    private $blogRepository;
    private $commentRepository;
    public function __construct(BlogRepository $blogRepository, CommentRepository $commentRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $blogs = $this->blogRepository->all();
        return $this->SuccessResponse($blogs, 200, "All BLogs");
        // return view("blog/index", ["blogs" => $blogs]);
    }

    public function show($id)
    {
        $blog = $this->blogRepository->find($id);
        if (!$blog)
        {
            return $this->ErrorResponse(404, "Blog Not found");
        }
        $comments = $this->commentRepository->getCommentsOnBlog($id); //here $id is blogid
        $blogWithComments = ["blog" => $blog, "comments" => $comments];
        return $this->SuccessResponse($blogWithComments, 200, "Here is your individual blog, id: $id");
        // return view("blog/show", ["blog" => $blog, "comments" => $comments]);
    }

    // public function create()
    // {
    //     return view('blog/create');
    // }

    public function store(BlogRequest $request)
    {
        if (Auth::guest())
        {
            return $this->ErrorResponse(403, "Not Authenticated");
        }

        if (request()->has('image'))
        {
            $image = request()->file('image');
            $extenstion = $image->getClientOriginalExtension();
            $newName = time() . '.' . $extenstion;
            $image->move(public_path('storage/images'), $newName);
        }

        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        $validated['image'] = $newName ?? "https://api.multiavatar.com/Doge.png";

        $blog = $this->blogRepository->create($validated);
        // dd($blog);
        return $this->SuccessResponse($blog, 201, "New Blog Created");
        // return redirect("/blogs/$blog->id")->with('newblog', "new blog created");
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        try
        {
            $blog = $this->blogRepository->update($blog->id, $request->validated());
            return $this->SuccessResponse($blog, 200, "Edit Successfully");

        } catch (\Throwable $th)
        {
            return $this->ErrorResponse($th->getCode(), $th->getMessage());
            // dd($th);
        }
        // dd($blog);
    }

    public function destroy(Blog $blog)
    {
        // $blog = $this->blogRepository->find($id);
        if (!$blog)
        {
            return $this->ErrorResponse(404, "Blog Not found");
        }
        // $deleted = $this->blogRepository->delete($id);
        $blog->delete();
        return $this->SuccessResponse($blog, 200, "Blog Deleted Successfully");
    }
}
