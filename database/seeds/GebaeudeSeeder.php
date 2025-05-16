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
        $bul = App\Building::factory()->make(5)->each(function ($geb) use ($location) {
            $geb->location_id = $location->random()->id;
            $geb->save();

            App\Storage::factory()->create(['storage_uid' => $geb->storage_id, 'storage_label' => $geb->b_label, 'storage_object_type' => 'buildings']);
        });
    }
}
