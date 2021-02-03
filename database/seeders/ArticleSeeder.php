<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); 
        for ($i=0; $i < 4; $i++) {
            $title = $faker->sentence(6);
            DB::table('articles')->insert([
                'categoryId' => rand(1,7),
                'title' => $title,
                'image' => $faker->imageUrl(800, 400,'cats', true, 'Blog Sitesi'),
                'content' => $faker->paragraph(6),
                'slug' => Str::slug($title),
                'created_at' => $faker->dateTime($max = 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
