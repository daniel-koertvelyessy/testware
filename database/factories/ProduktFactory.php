<?php

/** @var Factory $factory */

use App\Produkt;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Produkt::class, function (Faker $faker) {
    $int = random_int(1,10);
    return [
        'updated_at' => now()->subMonths($int),
        'created_at' => now()->subMonths($int),
        'prod_label' => 'pr.' . str_random(8),
        'prod_name' => $faker->slug(3),
        'produkt_kategorie_id' => 1,
        'prod_price' => random_int(100, 20000),
        'produkt_state_id' => random_int(1, 2),
        'prod_active' => random_int(0, 1),
        'prod_nummer' => '920' . random_int(100000, 999000),
    ];
});
