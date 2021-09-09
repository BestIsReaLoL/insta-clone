<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VoyagerDatabaseSeeder::class);
//        $this->call(UserSeeder::class);
//        $this->call(PostSeeder::class);
//        $this->call(ProfileUserSeeder::class);
        User::factory()->count(10)->create();
        Post::factory()->count(10)->create();

        echo "Like Data Seeding.. \n";

        $users = User::count();
        $posts = Post::count();

        for ($i = 1; $i <= $posts; $i++) {
            for ($j = 1; $j <= $users; $j++) {
                Like::updateOrCreate([
                    'post_id' => $i,
                    'user_id' => $j,
                    'status' => 1
                ]);
            }
        }
    }
}
