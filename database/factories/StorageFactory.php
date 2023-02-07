<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StorageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition():array
    {
        return [
            'storage_uid'         => '',
            'storage_label'       => '',
            'storage_object_type' => '',
        ];
    }
}
