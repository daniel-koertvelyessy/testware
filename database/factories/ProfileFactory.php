<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'         => User::factory()->create(),
            'ma_nummer'       => $this->faker->numberBetween(1000, 2000),
            'ma_name'         => $this->faker->lastName,
            'ma_name_2'       => $this->faker->name,
            'ma_vorname'      => $this->faker->firstName(1),
            'ma_geburtsdatum' => $this->faker->date('Y-m-d', time()),
            'ma_eingetreten'  => $this->faker->date('Y-m-d', time() - 60 * 60 * 24 * 18),
            'ma_telefon'      => $this->faker->phoneNumber,
            'ma_mobil'        => $this->faker->e164PhoneNumber,
        ];
    }
}
