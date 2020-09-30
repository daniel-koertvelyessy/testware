<?php

use Illuminate\Database\Seeder;

class GebaeudeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = App\Location::all();
        $bul =  factory(App\Building::class, 18)->make()->each(function ($geb) use ($location) {
            $geb->location_id = $location->random()->id;
            $geb->save();

          factory(App\Standort::class)->create(['std_id'=>$geb->standort_id, 'std_kurzel'=>$geb->b_name_kurz, 'std_objekt_typ'=>'buildings']);

        });

    }
}
