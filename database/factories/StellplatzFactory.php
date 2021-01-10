<?php

/** @var Factory $factory */

use App\Stellplatz;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Stellplatz::class, function (Faker $faker) {
    return [
        'sp_label' => 'SP.' . rand(1, 9) . '-' . str_random(6),
        'sp_name' => $faker->slug,
        'stellplatz_typ_id' => rand(1, 3),
        'storage_id' => $faker->uuid,
    ];
});
