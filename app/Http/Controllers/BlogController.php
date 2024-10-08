<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    private $blogRepository;
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
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
        // dd($blog);
        return view("blog/show", ["blog" => $blog]);
    }

    public function create()
    {
        return view('blog/create');
    }

    public function store()
    {
        if (Auth::guest())
        {
            abort(403);
        }
        $validated = request()->validate([

            'title' => ['required', 'min:10'],
            'content' => ['required', 'min:40'],
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif'
        ]);

        if (request()->has('image'))
        {
            $image = request()->file('image');
            $extenstion = $image->getClientOriginalExtension();
            $newName = time() . '.' . $extenstion;
            $image->move(public_path('storage/images'), $newName);
        }
        $validated['user_id'] = Auth::user()->id;
        $validated['image'] = $newName;

        $blog = $this->blogRepository->create($validated);
        // dd($blog);
        return redirect("/blogs/$blog->id")->with('newblog', "new blog created");
    }

    public function update($id)
    {
        $validated = request()->validate([

            'title' => ['required', 'min:10'],
            'content' => ['required', 'min:40'],
            // 'image' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif'
        ]);
        $blog = $this->blogRepository->update($id, $validated);
        // dd($blog);
        return redirect("/blogs/$id");
    }

    public function destroy($id)
    {
        $this->blogRepository->delete($id);
        return redirect("/blogs")->with('message', "Blog Deleted Successfuly!");
    }

}
