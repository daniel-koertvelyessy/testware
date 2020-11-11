<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            StandortSeeder::class,
            GebaeudeSeeder::class,
            RaumSeeder::class,
            ContactSeeder::class,
//            EquipmentSeeder::class
        ]);

    }
}
