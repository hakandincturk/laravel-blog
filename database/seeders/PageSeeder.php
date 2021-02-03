<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Hakkımızda', 'Kariyer', 'Vizyon', 'Misyon'];
        $count = 0;
        foreach ($pages as $page) {
            $count++;
            DB::table('pages')->insert([
                'title' => $page,
                'image' => 'https://miro.medium.com/max/8000/1*JrHDbEdqGsVfnBYtxOitcw.jpeg',
                'slug' => Str::slug($page),
                'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                              Cumque nulla, unde dignissimos numquam accusantium esse fuga earum consectetur 
                              necessitatibus at cum. Modi earum quasi harum, porro a eum quibusdam laboriosam.',
                'order' => $count,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
