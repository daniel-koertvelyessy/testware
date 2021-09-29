<?php

/** @var Factory $factory */

use App\LagertType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(LagertType::class, function (Faker $faker) {
    return [
        'lt_label' => substr('LF' . $faker->buildingNumber, 0, 9),
        'lt_name' => $faker->slug(3),
        'lt_description' => $faker->sentence(rand(5)),
    ];
});
