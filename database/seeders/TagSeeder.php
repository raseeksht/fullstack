<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $all_tags = ['science', 'fiction', 'romanic', 'mistery', 'thriller'];
        foreach ($all_tags as $tag)
        {
            Tag::create(['name' => $tag]);
        }
    }
}
