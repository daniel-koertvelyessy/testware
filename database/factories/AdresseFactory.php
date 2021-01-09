<?php

/** @var Factory $factory */

use App\Adresse;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Adresse::class, function (Faker $faker) {
    return [
        'address_type_id' => 1,
        'ad_label' => substr(substr($faker->companySuffix, 0, 3) . $faker->randomNumber(3) .  $faker->postcode, 0, 10),
        'ad_name' => $faker->address,
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
