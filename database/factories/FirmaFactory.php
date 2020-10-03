<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Adresse;
use App\Firma;
use Faker\Generator as Faker;

$factory->define(Firma::class, function (Faker $faker) {
    return [
        'fa_name_kurz' => 'fa-' . str_random(4) . '-' . random_int(10, 99),
        'fa_name_lang' => $faker->company,
        'fa_name_text' => $faker->paragraph(5),
        'fa_kreditor_nr' => random_int(52002, 52999),
        'fa_debitor_nr' => random_int(12002, 12999),
        'fa_vat' => 'DE' . random_int(120000002, 150000002),
        'adresse_id' => factory(Adresse::class),
    ];
});
