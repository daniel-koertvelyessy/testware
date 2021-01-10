<?php

/** @var Factory $factory */

use App\Storage;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Storage::class, function (Faker $faker) {
    return [
        'storage_uid' => '',
        'storage_label' => '',
        'storage_object_type' => '',
    ];
});
