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
        $bul =  factory(App\Building::class, 5)->make()->each(function ($geb) use ($location) {
            $geb->location_id = $location->random()->id;
            $geb->save();

            factory(App\Storage::class)->create(['storage_uid' => $geb->storage_id, 'storage_label' => $geb->b_label, 'storage_object_type' => 'buildings']);
        });
    }
}
