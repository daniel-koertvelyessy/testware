<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Lizenz extends Model
{
    protected $table = 'lizenz';

    protected $guarded = [];

    public static function getMaxObjects($id)
    {

        $liz = Lizenz::where('lizenz_id', $id)->first();

        return $liz->lizenz_max_objects;
    }

    public function checkNumObjectsOverflow()
    {
        $maxObj = Lizenz::getMaxObjects(config('app.lizenzid'));
        session('allowNewObject', (Lizenz::getNumObjekte() <= $maxObj));

        return Lizenz::getNumObjekte().' / '.$maxObj;

    }

    public static function getNumObjekte()
    {

        $numLocation = Cache::remember(
            'app-get-current-amount-Location',
            now()->addSeconds(30),
            function () {
                return Location::all()->count();
            }
        );

        $numBuilding = Cache::remember(
            'app-get-current-amount-Product',
            now()->addSeconds(30),
            function () {
                return Building::all()->count();
            }
        );

        $numRoom = Cache::remember(
            'app-get-current-amount-Room',
            now()->addSeconds(30),
            function () {
                return Room::all()->count();
            }
        );

        $numStellplatz = Cache::remember(
            'app-get-current-amount-Stellplatz',
            now()->addSeconds(30),
            function () {
                return Stellplatz::all()->count();
            }
        );

        $numEquipment = Cache::remember(
            'app-get-current-amount-Equipment',
            now()->addSeconds(30),
            function () {
                return Equipment::all()->count();
            }
        );

        return $numLocation + $numBuilding + $numRoom + $numStellplatz + $numEquipment;

    }
}
