<?php

use Illuminate\Database\Seeder;

class CatalogTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Event::class, 20)->create();
        factory(App\Models\Program::class, 20)->create();
        factory(App\Models\Seance::class, 100)->create();
    }
}
