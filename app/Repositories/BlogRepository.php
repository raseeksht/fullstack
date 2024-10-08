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

    public function findById($id)
    {
        return Blog::find($id)->first();
    }

    public function create(array $data)
    {
        return Blog::create($data);
    }

}