<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'Example Post 1',
            'slug' => 'example-post-1',
            'summary' => 'Summary for example post 1',
            'description' => 'Content for example post 1',
            'photo' => 'post1.jpg',
            'status' => 'active',
        ]);
    }
}
