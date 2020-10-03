<?php

/** @var Factory $factory */

use App\Standort;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Standort::class, function (Faker $faker) {
    return [
       'std_id' => '',
       'std_kurzel' => '',
       'std_objekt_typ' => '',
    ];
});
