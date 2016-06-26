<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlideTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slides')->insert([
            'title'       => 'Slide 1',
            'src'         => '/images/slider/img-main-slider-01.jpg',
            'caption'     => '{\"caption_title\":\"Slide 1\",\"caption_content\":\"Slide 1Slide 1Slide 1Slide 1\"}',
            'slider' => 'На главной',
            'published' => 1,
        ]);

        DB::table('slides')->insert([
            'title'       => 'Slide 2',
            'src'         => '/images/slider/img-main-slider-02.jpg',
            'caption'     => '{\"caption_title\":\"Slide 2\",\"caption_content\":\"Slide 2Slide 2Slide 2Slide 2\"}',
            'slider' => 'На главной',
            'published' => 1,
        ]);

        DB::table('slides')->insert([
            'title'       => 'Slide 3',
            'src'         => '/images/slider/img-main-slider-03.jpg',
            'caption'     => '{\"caption_title\":\"Slide 3\",\"caption_content\":\"Slide 3Slide 3Slide 3Slide 3\"}',
            'slider' => 'На главной',
            'published' => 1,
        ]);

        DB::table('slides')->insert([
            'title'       => 'Slide 4',
            'src'         => '/images/slider/img-main-slider-04.jpg',
            'caption'     => '{\"caption_title\":\"Slide 4\",\"caption_content\":\"Slide 4Slide 4Slide 4Slide 4\"}',
            'slider' => 'На главной',
            'published' => 1,
        ]);
    }
}
