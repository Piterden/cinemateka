<?php
// namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->insert([
            'name'      => 'Расписание',
            'type'      => 'internal_page',
            'link'      => 'schedule',
            'parent_id' => 0,
        ]);

        DB::table('menu_items')->insert([
            'name'      => 'Архив',
            'type'      => 'internal_page',
            'link'      => 'archive',
            'parent_id' => 0,
        ]);

        DB::table('menu_items')->insert([
            'name'      => 'О проекте',
            'type'      => 'internal_page',
            'link'      => 'about',
            'parent_id' => 0,
        ]);

        DB::table('menu_items')->insert([
            'name'      => 'Адреса и телефоны',
            'type'      => 'internal_page',
            'link'      => 'contacts',
            'parent_id' => 0,
        ]);
    }
}
