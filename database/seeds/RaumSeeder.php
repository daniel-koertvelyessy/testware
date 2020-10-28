<?php

use Illuminate\Database\Seeder;

class RaumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gebaeude = App\Building::all();
       $room = factory(App\Room::class, 14)->make()->each(function ($rom) use ($gebaeude) {
            $rom->building_id = $gebaeude->random()->id;
            $rom->save();
           factory(App\Standort::class)->create(['std_id'=>$rom->standort_id, 'std_kurzel'=>$rom->r_name_kurz, 'std_objekt_typ'=>'rooms']);
        });

        $stellplatz = factory(App\Stellplatz::class,48)->make()->each(function ($sp) use ($room){
            $sp->room_id = $room->random()->id;
            $sp->save();
            factory(App\Standort::class)->create(['std_id'=> $sp->standort_id, 'std_kurzel'=> $sp->sp_name_kurz, 'std_objekt_typ'=>'stellplatzs']);
        });


    }
}
