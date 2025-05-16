<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use InitialValueSeeder;

class DemodataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InitialValueSeeder::class,
            \UsersTableSeeder::class,
            \FirmaSeeder::class,
            LocationsSeeder::class,
            \EquipmentSeeder::class,
        ]);
    }
}
