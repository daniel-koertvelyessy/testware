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
            factory(App\Storage::class)->create(['storage_uid' => $rom->storage_id, 'storage_label' => $rom->r_label, 'storage_object_type' => 'rooms']);
        });

        $stellplatz = factory(App\Stellplatz::class, 48)->make()->each(function ($sp) use ($room) {
            $sp->room_id = $room->random()->id;
            $sp->save();
            factory(App\Storage::class)->create(['storage_uid' => $sp->storage_id, 'storage_label' => $sp->sp_label, 'storage_object_type' => 'stellplatzs']);
        });
    }
}
