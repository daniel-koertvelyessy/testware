<?php

use Illuminate\Database\Seeder;

class StandortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = factory(App\Location::class, 2)->create();

        foreach ($location as $loc)
            factory(App\Standort::class)->create([
                'std_id'=>$loc->standort_id,
                'std_kurzel'=>$loc->l_name_kurz,
                'std_objekt_typ'=>'locations'
            ]);
    }
}
