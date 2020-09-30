<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class),
        'ma_nummer' => $faker->numberBetween(1000, 2000),
        'ma_name' => $faker->lastName,
        'ma_name_2' => $faker->name,
        'ma_vorname' => $faker->firstName(1),
        'ma_geburtsdatum' => $faker->date('Y-m-d', time()),
        'ma_eingetreten' => $faker->date('Y-m-d', time() - 60 * 60 * 24 * 18),
        'ma_telefon' => $faker->phoneNumber,
        'ma_mobil' => $faker->e164PhoneNumber,
    ];
});
