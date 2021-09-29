<?php

/** @var Factory $factory */

use App\Building;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Building::class, function (Faker $faker) {
    $b_we_has = rand(0, 1);
    $b_we_name = ($b_we_has === 1) ? $faker->buildingNumber : '';
    return [
        'b_label' => substr('geb-' . rand(1000, 9999), 0, 9),
        'b_name_ort' => $faker->buildingNumber,
        'b_name' => $faker->slug(2),
        'b_description' => $faker->paragraph(5),
        'b_we_has' => $b_we_has,
        'b_we_name' => $b_we_name,
        'storage_id' => $faker->uuid,
        'building_type_id' => 1
    ];
});
