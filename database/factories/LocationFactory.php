<?php

namespace database\factories;

use App\Adresse;
use App\Profile;
use App\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition():array
    {
        $label = substr('bln' . rand(100, 300), 0, 10);
        $uuid = $this->faker->uuid;
        Storage::factory()->create(['storage_uid' => $uuid, 'storage_label' => $label, 'storage_object_type' => 'locations']);

        return [
            'l_label'        => $label,
            'l_benutzt'      => $this->faker->dateTimeThisMonth,
            'l_name'         => $this->faker->slug(3),
            'l_beschreibung' => $this->faker->paragraph(5),
            'adresse_id'     => Adresse::factory()->create(),
            'profile_id'     => Profile::factory()->create(),
            'storage_id'     => $uuid,
        ];
    }
}
