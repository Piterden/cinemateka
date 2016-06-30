<?php

// namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('places')->insert([
            'published'   => 1,
            'title'       => 'Аврора',
            'slug'        => 'avrora',
            'address'     => 'Невский пр., 60, Санкт-Петербург',
            'metro'       => 'Гостинный двор',
            'description' => $faker->paragraph(30),
        ]);

        DB::table('places')->insert([
            'published'   => 1,
            'title'       => 'Дом кино',
            'slug'        => 'dom-kino',
            'address'     => 'Караванная ул., 12, Санкт-Петербург',
            'metro'       => 'Гостинный двор',
            'description' => $faker->paragraph(30),
        ]);

        DB::table('places')->insert([
            'published'   => 1,
            'title'       => 'Родина',
            'slug'        => 'rodina',
            'address'     => 'Караванная ул., 12, Санкт-Петербург',
            'metro'       => 'Гостинный двор',
            'description' => $faker->paragraph(30),
        ]);

        DB::table('places')->insert([
            'published'   => 1,
            'title'       => 'Художественный',
            'slug'        => 'hudozhestvenniy',
            'address'     => 'Невский пр., 67, Санкт-Петербург',
            'metro'       => 'Маяковская',
            'description' => $faker->paragraph(30),
        ]);
    }
}
