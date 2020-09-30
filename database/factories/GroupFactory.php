<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'grp_name_kurz' => 'pg-'.str_random(4).'-'.str_random(2),
        'grp_name_lang' => $faker->slug(3),
        'profile_id' =>rand(1-4),
        'division_id' => rand(1-3),
    ];
});
