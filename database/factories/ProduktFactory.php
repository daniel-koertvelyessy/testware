<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produkt;
use Faker\Generator as Faker;

$factory->define(Produkt::class, function (Faker $faker) {
    return [
        'created_at' => $faker->time('now'),
        'prod_name_kurz' => 'pr-'.str_random(8),
        'prod_name_lang' => $faker->slug(3),
        'produkt_kategorie_id' => random_int(1,3),
        'produkt_state_id' => random_int(1,2),
        'prod_active' => random_int(1,2),
        'prod_nummer' => '920'.random_int(100000,999000),
    ];
});
