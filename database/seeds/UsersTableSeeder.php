<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Denis Efremov',
            'email' => 'efremov.a.denis@gmail.com',
            'password' => bcrypt('Mic50keY'),
        ]);

        DB::table('users')->insert([
            'name' => 'Evgeniy Kulakov',
            'email' => 'kulakov.e@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
    }
}
