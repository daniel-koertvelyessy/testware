<?php

namespace Database\Factories;

use App\Equipment;
use App\EquipmentFuntionControl;
use App\Firma;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFuntionControlFactory extends Factory
{
    protected $model = EquipmentFuntionControl::class;

    public function definition(): array
    {
        return [
            'controlled_at' => $this->faker->date(),
            'function_control_firma' => $this->faker->randomElement(Firma::all()->pluck('id')->toArray()),
            'function_control_profil' => null,
            'function_control_pass' => $this->faker->boolean(),
            'function_control_text' => $this->faker->realText(),
            'equipment_id' => $this->faker->randomElement(Equipment::all()->pluck('id')->toArray())

        ];

    }
}