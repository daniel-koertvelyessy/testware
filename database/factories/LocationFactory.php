<?php

/** @var Factory $factory */

use App\Location;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'l_label' => substr('bln' . rand(100, 300), 0, 10),
        'l_benutzt' => $faker->dateTimeThisMonth,
        'l_name' => $faker->slug(3),
        'l_beschreibung' => $faker->paragraph(5),
        'adresse_id' => factory(App\Adresse::class),
        'profile_id' => factory(App\Profile::class),
        'standort_id' => $faker->uuid,
    ];
});
