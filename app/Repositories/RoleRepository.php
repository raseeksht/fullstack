<?php

namespace App\Repositories;
use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {
        return Role::all();
    }

    public function createNewRole($role)
    {
        return Role::create(['title' => $role]);
    }


}