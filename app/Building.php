<?php

namespace App;

use App\Stellplatz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

class Building extends Model {
    use SoftDeletes, Sortable;

    /**
     * Returns the path of the page
     *
     * @return string
     */

    protected $guarded = [];

    public static function boot() {
        parent::boot();
        static::saving(function (Building $building) {
            Cache::forget('app-get-current-amount-Product');
            Cache::forget('countTotalEquipmentInBuilding');
        });
        static::updating(function (Building $building) {
            Cache::forget('app-get-current-amount-Product');
            Cache::forget('countTotalEquipmentInBuilding');
        });
    }

    public function search($term) {
        return Building::where('b_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('b_name_ort', 'like', '%' . $term . '%')
            ->orWhere('b_name_lang', 'like', '%' . $term . '%')
            ->orWhere('b_name_text', 'like', '%' . $term . '%')
            ->orWhere('b_we_name', 'like', '%' . $term . '%')
            ->get();
    }

    public function path() {
        return route('building.show', $this);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function BuildingType() {
        return $this->belongsTo(BuildingTypes::class);
    }

    public function rooms() {
        return $this->hasMany(Room::class, 'building_id');
    }

    public function countStellPlatzs(Building $building) {
        $n = 0;
        foreach ($building->rooms->pluck('id') as $rid) {
            $n += count(Stellplatz::where('room_id', $rid)->get());
        }
        return $n;
    }

    public function Standort() {
        return $this->hasOne(Standort::class, 'std_id', 'standort_id');
    }

    public function countTotalEquipmentInBuilding() {
        Cache::remember(
            'countTotalEquipmentInBuilding',
            now()->addSeconds(30),
            function () {
                $equipCounter = 0;
                $equipCounter += $this->Standort->countReferencedEquipment();
                $rooms = Room::where('building_id', $this->id)->get();
                foreach ($rooms as $room) {
                    $equipCounter += $room->Standort->countReferencedEquipment();
                    $compartments = Stellplatz::where('room_id', $room->id)->get();
                    foreach ($compartments as $compartment) {
                        $equipCounter += $compartment->Standort->countReferencedEquipment();
                    }
                }
                return $equipCounter;
            });
    }

}
