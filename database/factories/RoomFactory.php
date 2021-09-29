<?php

/** @var Factory $factory */

use App\Room;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'r_label' => substr('rm-' . rand(100, 200), 0, 10),
        'r_name' => $faker->slug(1),
        'r_description' => $faker->paragraph(5),
        'room_type_id' => rand(1, 3),
        'storage_id' => $faker->uuid,
    ];
});
