<?php
namespace Database\Seeds;

use Illuminate\Database\Seeder;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('places')->insert([
            'published' => 'Denis Efremov',
            'title' => 'efremov.a.denis@gmail.com',
            'slug' => bcrypt('Mic50keY'),
            'address' => 'Denis Efremov',
            'metro' => 'efremov.a.denis@gmail.com',
            'description' => 'Denis Efremov',
        ]);

        DB::table('places')->insert([
            'published' => 'Denis Efremov',
            'title' => 'efremov.a.denis@gmail.com',
            'slug' => bcrypt('Mic50keY'),
            'address' => 'Denis Efremov',
            'metro' => 'efremov.a.denis@gmail.com',
            'description' => 'Denis Efremov',
        ]);

        DB::table('places')->insert([
            'published' => 'Denis Efremov',
            'title' => 'efremov.a.denis@gmail.com',
            'slug' => bcrypt('Mic50keY'),
            'address' => 'Denis Efremov',
            'metro' => 'efremov.a.denis@gmail.com',
            'description' => 'Denis Efremov',
        ]);

        DB::table('places')->insert([
            'published' => 'Denis Efremov',
            'title' => 'efremov.a.denis@gmail.com',
            'slug' => bcrypt('Mic50keY'),
            'address' => 'Denis Efremov',
            'metro' => 'efremov.a.denis@gmail.com',
            'description' => 'Denis Efremov',
        ]);

    }
}
