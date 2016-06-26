<?php
namespace Database\Seeds;

use Illuminate\Database\Seeder;

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

    //     DB::table('pages')->insert([
    //         'name'     => 'about',
    //         'template' => 'static_page',
    //         'title'    => 'О проекте',
    //         'slug'     => 'about',
    //         'content'  => $faker->paragraph(25),
    //     ]);
    //
    //     DB::table('pages')->insert([
    //         'name'     => 'contacts',
    //         'template' => 'static_page',
    //         'title'    => 'Контакты',
    //         'slug'     => 'contacts',
    //         'content'  => $faker->paragraph(25),
    //     ]);
    }
}
