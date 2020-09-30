<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address_type_id' => 1,
        'ad_name_kurz' => substr(substr($faker->companySuffix, 0, 3) . $faker->randomNumber(3) .  $faker->postcode, 0, 10),
        'ad_name_lang' => $faker->address,
        'ad_name_firma' => $faker->company,
        'ad_name_firma_2' => $faker->companySuffix,
        'ad_name_firma_co' => $faker->companySuffix,
        'ad_name_firma_abladestelle' => $faker->companySuffix,
        'ad_name_firma_wareneingang' => $faker->companySuffix,
        'ad_name_firma_abteilung' => $faker->swiftBicNumber,
        'ad_anschrift_strasse' => $faker->streetName,
        'ad_anschrift_hausnummer' => $faker->buildingNumber,
        'ad_anschrift_etage' => '2',
        'ad_anschrift_eingang' => '3',
        'ad_anschrift_plz' => $faker->postcode,
        'ad_anschrift_ort' => $faker->city,
        'land_id' => 1
    ];
});
