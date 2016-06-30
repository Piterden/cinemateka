<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(SlideTableSeeder::class);
        $this->call(MenuItemTableSeeder::class);
        $this->call(PlacesTableSeeder::class);
        $this->call(CatalogTablesSeeder::class);

        Model::reguard();
    }
}
