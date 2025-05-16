<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StorageFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'storage_uid' => Str::uuid(),
            'storage_label' => '',
            'storage_object_type' => '',
        ];
    }
}
