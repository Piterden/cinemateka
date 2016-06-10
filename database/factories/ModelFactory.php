<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'published'        => 1,
        'title'            => $faker->words(rand(1, 5), true),
        'slug'             => $faker->slug,
        'event_type'       => $faker->randomElement(array_pluck(App\Models\Category::all(['name']), 'name')),
        'description'      => $faker->paragraph(25),
        'orig_title'       => $faker->words(rand(1, 5), true),
        'year'             => $faker->year,
        'country'          => $faker->country,
        'carrier'          => $faker->randomElement(['DCP', '35 mm', 'Blu-ray']),
        'language'         => $faker->languageCode,
        'subtitles'        => $faker->languageCode,
        'director'         => $faker->firstName.' '.$faker->lastName,
        'writtenby'        => $faker->firstName.' '.$faker->lastName,
        'operator'         => $faker->firstName.' '.$faker->lastName,
        'producer'         => $faker->firstName.' '.$faker->lastName,
        'link'             => $faker->url,
        'chrono'           => $faker->numberBetween(80, 220),
        'age_restrictions' => $faker->numberBetween(0, 18),
    ];
});

$factory->define(App\Models\Program::class, function (Faker\Generator $faker) {
    return [
        'published'   => 1,
        'title'       => $faker->words(rand(1, 5), true),
        'slug'        => $faker->slug,
        'description' => $faker->paragraph(25),
        'start_date'  => $faker->date(),
        'end_date'    => $faker->date(),
        'slogan'      => $faker->sentence(4),
    ];
});

$factory->define(App\Models\Seance::class, function (Faker\Generator $faker) {
    return [
        'start_time'   => $faker->dateTimeThisYear,
        'price'        => $faker->randomElement(['300', '400', '500', '600', '700']),
        'description'  => $faker->paragraph(25),
        'speaker_info' => $faker->paragraph(25),
        'event_id'     => $faker->randomElement(array_pluck(App\Models\Event::all(['id']), 'id')),
        'program_id'   => $faker->randomElement(array_pluck(App\Models\Program::all(['id']), 'id')),
    ];
});