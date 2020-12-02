<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Equipment;
use Faker\Generator as Faker;

$factory->define(Equipment::class, function (Faker $faker) {
    $uid = \Illuminate\Support\Str::uuid();
    return [
        'eq_inventar_nr' => 'inv20'.substr($uid,0,50),
        'eq_serien_nr' => $faker->unique()->bankAccountNumber,
        'eq_ibm' => $faker->date('Y-m-d'),
        'eq_text' => $faker->text(100),
        'eq_uid' => $uid,
        'equipment_state_id' => 1,
        'produkt_id' => NULL,
        'standort_id' => NULL,
    ];
});
