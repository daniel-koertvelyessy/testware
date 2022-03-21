<?php

namespace App\Console\Commands;

use App\Building;
use App\Location;
use App\Room;
use App\Stellplatz;
use App\Storage;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Str;

class SyncStoragesCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testware:syncstorages
                    {--show : Display the hskey instead of modifying files}
                    {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the location objects with the Storage table';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Syncronization of storage objects');
        $this->newLine();
        $bar = $this->output->createProgressBar(
            Location::all()->count() +
            Building::all()->count() +
            Room::all()->count() +
            Stellplatz::all()->count()
        );


        /**
         *   Search for location objects wich are not stored in the Storage table
         */

        $missingLocation = [];
        $missingBuilding = [];
        $missingRoom = [];
        $missingCompartment = [];

        $countRepairedUuids = 0;

        $this->info('Search for location objects wich are not stored in the Storage table');
        $this->newLine();
        $bar->start();
        foreach (Location::select('id', 'l_label', 'storage_id')->get() as $place) {

            /**
             * Check if $place has an uuid
             */
            if (is_null($place->storage_uid)) {
                /**
                 * check if $place exists in Storage table
                 */
                $place->storage_id = $this->getStorageUUID('locations', $place->l_label);
                $place->save();
                $countRepairedUuids++;
            }

            if (Storage::where('storage_uid', $place->storage_id)->count() === 0) {
                $missingLocation[$place->storage_id] = $this->sycStorage($place->storage_id, $place->l_label, 'locations');

            }
            $bar->advance();
        }

        foreach (Building::select('id', 'b_label', 'storage_id')->get() as $place) {

            /**
             * Check if $place has an uuid
             */
            if (is_null($place->storage_uid)) {
                /**
                 * check if $place exists in Storage table
                 */
                $place->storage_id = $this->getStorageUUID('buildings', $place->b_label);
                $place->save();
                $countRepairedUuids++;
            }

            if (Storage::where('storage_uid', $place->storage_id)->count() === 0) {
                $missingBuilding[$place->storage_id] = $this->sycStorage($place->storage_id, $place->b_label, 'buildings');;
            }
            $bar->advance();
        }

        foreach (Room::select('id', 'r_label', 'storage_id')->get() as $place) {
            if (Storage::where('storage_uid', $place->storage_id)->count() === 0) {
                $missingRoom[$place->storage_id] = $this->sycStorage($place->storage_id, $place->r_label, 'rooms');;
            }
            $bar->advance();
        }

        foreach (Stellplatz::select('id', 'sp_label', 'storage_id')->get() as $place) {
            if (Storage::where('storage_uid', $place->storage_id)->count() === 0) {
                $missingCompartment[$place->storage_id] = $this->sycStorage($place->storage_id, $place->sp_label, 'stellplatzs');;
            }
            $bar->advance();
        }


        $bar->finish();
        $this->newLine();
        $this->info('search for uid\'s in storages which do not have a matching location object');
        $this->newLine();
     //   $bar->start();
        /**
         * search for uid's in storages which do not have a matching location object
         */
        $storageEmptyLocations = [];
        $storageEmptyBuildings = [];
        $storageEmptyRooms = [];
        $storageEmptyCompartments = [];

        foreach (Storage::where('storage_object_type', 'locations')->get() as $storeItem) {
            if (Location::where('storage_id', $storeItem->storage_uid)->count() === 0) {
                $storageEmptyLocations[] = $storeItem->storage_uid;
                $storeItem->delete();
            }
        }

        foreach (Storage::where('storage_object_type', 'buildings')->get() as $storeItem) {
            if (Building::where('storage_id', $storeItem->storage_uid)->count() === 0) {
                $storageEmptyBuildings[] = $storeItem->storage_uid;
                $storeItem->delete();
            }
        }

        foreach (Storage::where('storage_object_type', 'rooms')->get() as $storeItem) {
            if (Room::where('storage_id', $storeItem->storage_uid)->count() === 0) {
                $storageEmptyRooms[] = $storeItem->storage_uid;
                $storeItem->delete();
            }
        }

        foreach (Storage::where('storage_object_type', 'stellplatzs')->get() as $storeItem) {
            if (Stellplatz::where('storage_id', $storeItem->storage_uid)->count() === 0) {
                $storageEmptyCompartments[] = $storeItem->storage_uid;
                $storeItem->delete();
            }
        }


        $this->info('Application hskey set successfully.');
    }

    /**
     * @param String $type
     * @param String $label
     * @return String
     */
    protected function getStorageUUID(string $type, string $label)
    {
        $storages = Storage::where('storage_label', $label);
        if ($storages->count() > 0) {
            $storage = $storages->first();
            /**
             * check if found $storage is of given $type
             * and return its uuid or make a new on
             */
            return ($storage->storage_object_type === $type) ?
                $storage->storage_uid
                : Str::uuid();
        } else {
            return Str::uuid();
        }
    }

    public function sycStorage($uid, $label, $table)
    {
        $storeage = new Storage();
        $storeage->storage_uid = $uid;
        $storeage->storage_label = $label;
        $storeage->storage_object_type = $table;
        return $storeage->save();
    }

    public function sycStorages()
    {


    }
}
