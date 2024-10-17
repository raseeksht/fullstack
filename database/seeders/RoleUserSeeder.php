<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::where('email', 'admin@admin.com')->first();

        $adminRole = Role::where('title', 'admin')->first();

        $user1->roles()->attach($adminRole->id);


    }
}
