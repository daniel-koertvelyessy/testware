<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProduktFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'updated_at' => now()->subMonths(2),
            'created_at' => now()->subMonths(3),
            'prod_label' => 'pr.' . str_random(8),
            'prod_name' => $this->faker->slug(3),
            'produkt_kategorie_id' => 1,
            'prod_price' => random_int(100, 20000),
            'produkt_state_id' => random_int(1, 2),
            'prod_active' => random_int(0, 1),
            'prod_nummer' => '920' . random_int(100000, 999000),
            'prod_uuid' => Str::uuid(),
            'equipment_label_id' => 1
        ];
    }
}
