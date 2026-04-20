<?php

namespace seeders;

use Illuminate\Database\Seeder;

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
            \seeders\UsersTableSeeder::class,
            \seeders\FirmaSeeder::class,
            LocationsSeeder::class,
            \seeders\EquipmentSeeder::class,
        ]);
    }
}
