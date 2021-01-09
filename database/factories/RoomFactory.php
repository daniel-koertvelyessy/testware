<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'r_label' => substr('rm-' . rand(100, 200), 0, 10),
        'r_name' => $faker->slug(1),
        'r_name_text' => $faker->paragraph(5),
        'room_type_id' => rand(1, 3),
        'standort_id' => $faker->uuid,
    ];
});
