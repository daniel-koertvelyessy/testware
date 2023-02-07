<?php

namespace Database\Factories;

use App\Produkt;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'eq_inventar_nr'     => 'inv20' . substr($this->faker->uuid(), 0, 50),
            'eq_serien_nr'       => $this->faker->unique()->bankAccountNumber,
            'installed_at'       => $this->faker->date('Y-m-d'),
            'eq_text'            => $this->faker->text(100),
            'eq_uid'             => $this->faker->uuid(),
            'equipment_state_id' => round(1 + (pow(rand(0, 4) / 4, 4) * (4 - 1))),
            'produkt_id'         => 2,
            'storage_id'         => NULL,
            'eq_price'           => random_int(20, 10000)
        ];
    }
}
