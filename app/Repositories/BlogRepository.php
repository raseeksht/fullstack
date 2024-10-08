<?php

namespace App\Repositories;
use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;


class BlogRepository implements BlogRepositoryInterface
{
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