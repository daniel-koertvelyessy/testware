<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Divison;
use Faker\Generator as Faker;

$factory->define(Divison::class, function (Faker $faker) {
    return [
        'div_name_kurz'=>'pg-'.str_random(4),
        'div_name_lang'=>$faker->slug(3),
        'profile_id'=>rand(1,4)
    ];
});
