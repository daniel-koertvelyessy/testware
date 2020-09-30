<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stellplatz;
use Faker\Generator as Faker;

$factory->define(Stellplatz::class, function (Faker $faker) {
    return [
        'sp_name_kurz' => 'SP.'.rand(1,9).'-'.str_random(6),
        'sp_name_lang' => $faker->slug,
        'stellplatz_typ_id' => rand(1,3),
        'standort_id' => $faker->uuid,
    ];
});
