<?php

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
         
         $this->call(UsersTableSeeder::class);
         $this->call(BlogCategoriesTableSeeder::class);
         //используем фабрику php artisan make:factory BlogPostFactory
         factory(\App\Models\BlogPost::class, 100)->create();
    }
}



// factory(App\User::class, 50)->create()->each(function ($user) {
//      $user->posts()->save(factory(App\Post::class)->make());
//  });
