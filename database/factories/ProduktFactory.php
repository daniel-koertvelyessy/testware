<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produkt;
use Faker\Generator as Faker;

$factory->define(Produkt::class, function (Faker $faker) {
    return [
        'updated_at' => $faker->time('now'),
        'created_at' => $faker->time('now'),
        'prod_label' => 'pr.' . str_random(8),
        'prod_name' => $faker->slug(3),
        'produkt_kategorie_id' => 1,
        'produkt_state_id' => random_int(1, 2),
        'prod_active' => random_int(0, 1),
        'prod_nummer' => '920' . random_int(100000, 999000),
    ];
});
