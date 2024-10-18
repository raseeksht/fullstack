<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
    private $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    public function index()
    {
        return $this->roleRepository->all();
    }

    public function store()
    {
        $validated = request()->validate([
            "title" => "required|min:3|unique:roles"
        ]);

        return $this->roleRepository->createNewRole($validated['title']);
    }
}
