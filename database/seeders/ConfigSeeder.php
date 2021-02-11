<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'title'=> 'Blog Sitesi V1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
