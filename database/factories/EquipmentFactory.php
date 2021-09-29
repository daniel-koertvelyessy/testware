<?php

/** @var Factory $factory */

use App\Equipment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Equipment::class, function (Faker $faker) {
    $uid = \Illuminate\Support\Str::uuid();
    return [
        'eq_inventar_nr' => 'inv20' . substr($uid, 0, 50),
        'eq_serien_nr' => $faker->unique()->bankAccountNumber,
        'installed_at' => $faker->date('Y-m-d'),
        'eq_text' => $faker->text(100),
        'eq_uid' => $uid,
        'equipment_state_id' => round(1 + (pow(rand(0, 4) / 4, 4) * (4 - 1))),
        'produkt_id' => NULL,
        'storage_id' => NULL,
        'eq_price' => random_int(20, 10000)
    ];
});
