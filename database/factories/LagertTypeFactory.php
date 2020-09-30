<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LagertType;
use Faker\Generator as Faker;

$factory->define(LagertType::class, function (Faker $faker) {
    return [
        'lt_name_kurz' => substr('LF'.$faker->buildingNumber,0,9),
        'lt_name_lang' => $faker->slug(3),
        'lt_name_text' => $faker->sentence(rand(5)),
    ];
});
