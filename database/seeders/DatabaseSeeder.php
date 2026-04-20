<?php

namespace seeders;

use Illuminate\Database\Seeder;
use seeders;

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
            seeders\UsersTableSeeder::class,
            seeders\FirmaSeeder::class,
            LocationsSeeder::class,
            seeders\EquipmentSeeder::class,
        ]);
    }
}
