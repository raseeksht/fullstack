<?php

namespace App\Repositories;
use App\Models\Blog;
use App\Models\Comment;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;


class BlogRepository implements BlogRepositoryInterface
{
    use AuthorizesRequests;
    public function all()
    {
        return Blog::with('user')->paginate(3);
    }

    public function find($id)
    {
        return Blog::find($id);
    }

    public function create(array $data)
    {
        return Blog::create($data);
    }

    public function update($id, array $data)
    {
        $blog = Blog::find($id);

        // with policy
        $this->authorize('update', $blog);
        // $this->authorize('edit', $id);


        // used gate here
        // if (Auth::user()->cannot('edit-blog', $blog))
        // {
        //     throw new \Exception('Access Denied Cannot edit blocked through gate', 403);
        // }
        $blog->title = $data['title'];
        $blog->content = $data['content'];
        $blog->save();
        return $blog;
    }

    public function delete($id)
    {
        Blog::destroy($id);
        return true;
    }



}