<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return $this->ApiResponse(200, "All BLogs", $blogs);
        // return view("blog/index", ["blogs" => $blogs]);
    }

    public function show($id)
    {
        $blog = $this->blogRepository->find($id);
        $comments = $this->commentRepository->getCommentsOnBlog($id); //here $id is blogid
        $blogWithComments = ["blog" => $blog, "comments" => $comments];
        return $this->ApiResponse(200, "Here is your individual blog, id: $id", $blogWithComments);
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
            return $this->ApiError(403, "Not Authenticated");
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
        return $this->ApiResponse(201, "New Blog Created", $blog);
        // return redirect("/blogs/$blog->id")->with('newblog', "new blog created");
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = $this->blogRepository->update($id, $request->validated());
        // dd($blog);
        return $this->ApiResponse(200, "Edit Successfully", $blog);
    }

    public function destroy($id)
    {
        $blog = $this->blogRepository->find($id);
        if (!$blog)
        {
            return $this->ApiError(404, "Blog Not found");
        }
        $deleted = $this->blogRepository->delete($id);
        return $this->ApiResponse(200, "Blog Deleted Successfully", $deleted);
    }
}
