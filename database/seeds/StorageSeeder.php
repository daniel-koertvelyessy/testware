<?php

use App\Location;
use App\Storage;
use Illuminate\Database\Seeder;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $location = Location::factory()->count(2)->create();

        foreach ($location as $loc) {
            Storage::factory()->create([
                'storage_uid' => $loc->storage_id,
                'storage_label' => $loc->l_label,
                'storage_object_type' => 'locations',
            ]);
        }
    }
}
