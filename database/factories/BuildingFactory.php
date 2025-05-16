<?php

use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingFactory extends Factory
{
    public function definition(): array
    {
        $b_we_has = rand(0, 1);
        $b_we_name = ($b_we_has === 1)
            ? $this->faker->buildingNumber
            : '';

        return [
            'b_label' => substr('geb-'.rand(1000, 9999), 0, 9),
            'b_name_ort' => $this->faker->buildingNumber,
            'b_name' => $this->faker->slug(2),
            'b_description' => $this->faker->paragraph(5),
            'b_we_has' => $b_we_has,
            'b_we_name' => $b_we_name,
            'storage_id' => $this->faker->uuid,
            'building_type_id' => 1,
        ];
    }
}
