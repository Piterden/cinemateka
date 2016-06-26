<?php
namespace Database\Seeds;

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
        factory(App\Models\Event::class, 100)->create();
        factory(App\Models\Program::class, 30)->create();
        factory(App\Models\Seance::class, 300)->create();
        // factory(App\Models\Place::class, 10)->create();
    }
}
