<?php

/** @var Factory $factory */

use App\Divison;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Divison::class, function (Faker $faker) {
    return [
        'div_label' => 'pg-'.str_random(4),
        'div_name' => $faker->slug(3),
        'profile_id' => rand(1, 4),
    ];
});
