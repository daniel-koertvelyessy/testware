<?php

use Database\Seeders\LocationsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
