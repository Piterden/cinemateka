<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * фильм, лекция, выставка, конференция
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Фильм',
        ]);

        DB::table('categories')->insert([
            'name' => 'Лекция',
        ]);

        DB::table('categories')->insert([
            'name' => 'Выставка',
        ]);

        DB::table('categories')->insert([
            'name' => 'Конференция',
        ]);
    }
}
