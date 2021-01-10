<?php

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
        $location = factory(App\Location::class, 2)->create();

        foreach ($location as $loc)
            factory(App\Storage::class)->create([
                'storage_uid' => $loc->storage_id,
                'storage_label' => $loc->l_label,
                'storage_objekt_typ' => 'locations'
            ]);
    }
}
