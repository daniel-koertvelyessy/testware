<?php

/** @var Factory $factory */

use App\Contact;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Contact::class, function (Faker $faker) {

  $gender = rand(1, 2);
  $faker->firstName('male');
  $fn = ($gender === 1) ? $faker->firstName('male') : $faker->firstName('female');
  $nn = ($gender === 1) ? $faker->name('male') : $faker->name('female');

  $idn = 'con-' . substr($fn, 0, 5) . '_' . substr($nn, 0, 5);
  return [
    'con_label' => $idn,
    'con_name' => $nn,
    'con_vorname' => $fn,
    'con_email' => $faker->email,
    'con_telefon' => $faker->phoneNumber,
    'con_mobil' => $faker->phoneNumber,
    'con_fax' => $faker->phoneNumber,
    'firma_id' => factory(App\Firma::class),
    'anrede_id' => $gender,
  ];
});
