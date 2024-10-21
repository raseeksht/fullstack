<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => "admin"]);
        $author = Role::create(['name' => 'author']);
        $editor = Role::create(['name' => "editor"]);
        $audience = Role::create(['name' => "audience"]);

        $createUser = Permission::create(['name' => "createUser"]);
        $createBlog = Permission::create(['name' => "createBlog"]);
        $editBlog = Permission::create(['name' => "editBlog"]);
        $comment = Permission::create(['name' => "makeComment"]);
        $assignRoleToUser = Permission::create(['name' => "assignRole"]);

        $admin->givePermissionTo($createUser);
        $admin->givePermissionTo($assignRoleToUser);
        $admin->givePermissionTo($createBlog);
        $author->givePermissionTo($createBlog);
        $editor->givePermissionTo($editBlog);
        $audience->givePermissionTo($comment);

        $adminUser = User::where("email", "admin@admin.com")->first()->assignRole(['admin']);
        $adminUser = User::where("email", "admin@admin.com")->first()->assignRole(['author']);


    }
}
