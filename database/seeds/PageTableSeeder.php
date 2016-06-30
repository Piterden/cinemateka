<?php
// namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('pages')->insert([
            'name'     => 'index',
            'template' => 'static_page',
            'title'    => 'Главная',
            'slug'     => '/',
            'content'  => $faker->paragraph(25),
        ]);
    }
}
