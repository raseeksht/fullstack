<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Repositories\BlogRepository;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
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
        // dd($posts);
        return view("blog/index", ["blogs" => $blogs]);
    }

    public function show($id)
    {
        $blog = $this->blogRepository->find($id);
        $comments = $this->commentRepository->getCommentsOnBlog($id); //here $id is blogid
        // dd($comments);
        // dd($blog);
        return view("blog/show", ["blog" => $blog, "comments" => $comments]);
    }

    public function create()
    {
        return view('blog/create');
    }

    public function store(BlogRequest $request)
    {
        if (Auth::guest())
        {
            abort(403);
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
        $validated['image'] = $newName;

        $blog = $this->blogRepository->create($validated);
        // dd($blog);
        return redirect("/blogs/$blog->id")->with('newblog', "new blog created");
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = $this->blogRepository->update($id, $request->validated());
        // dd($blog);
        return redirect("/blogs/$id");
    }

    public function destroy($id)
    {
        $this->blogRepository->delete($id);
        return redirect("/blogs")->with('message', "Blog Deleted Successfuly!");
    }



}
