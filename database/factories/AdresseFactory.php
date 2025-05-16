<?php

namespace Database\Factories;

use App\AddressType;
use App\Land;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdresseFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'address_type_id' => AddressType::first()->id,
            'ad_label' => substr(substr($this->faker->companySuffix, 0, 3).$this->faker->randomNumber(3).$this->faker->postcode, 0, 10),
            'ad_name' => $this->faker->address,
            'ad_name_firma' => $this->faker->company,
            'ad_name_firma_2' => $this->faker->companySuffix,
            'ad_name_firma_co' => $this->faker->companySuffix,
            'ad_name_firma_abladestelle' => $this->faker->companySuffix,
            'ad_name_firma_wareneingang' => $this->faker->companySuffix,
            'ad_name_firma_abteilung' => $this->faker->swiftBicNumber,
            'ad_anschrift_strasse' => $this->faker->streetName,
            'ad_anschrift_hausnummer' => $this->faker->buildingNumber,
            'ad_anschrift_etage' => '2',
            'ad_anschrift_eingang' => '3',
            'ad_anschrift_plz' => $this->faker->postcode,
            'ad_anschrift_ort' => $this->faker->city,
            'land_id' => Land::first()->id,
        ];
    }
}
