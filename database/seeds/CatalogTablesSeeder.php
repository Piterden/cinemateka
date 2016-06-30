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
        factory(App\Models\Program::class, 8)->create();
        echo "8 programs done\n\r";

        factory(App\Models\Event::class, 30)->create()
        ->each(function ($e)
        {
            for ($i = 0; $i < rand(2, 5); ++$i)
            {
                $e->seances()
                ->save(factory(App\Models\Seance::class)->make());
            }
            echo "event $e->id done\n\r";
        });
    }
}
