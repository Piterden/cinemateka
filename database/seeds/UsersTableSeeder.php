<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
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
