<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Building;
use DB;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

class Location extends Model
{

    use SoftDeletes, Sortable;
    /*
 *
 *    Schütz nicht vor Injektionsangriffen!!!!


    protected $fillable = [
        'l_label',
        'l_name',
        'l_beschreibung',
        'adress_id',
        'profile_id'
    ];

*/

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Location $location) {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
        });
        static::updating(function (Location $location) {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
        });
    }

    public function search($term)
    {
        return Location::where('l_label', 'like', '%' . $term . '%')
            ->orWhere('l_name', 'like', '%' . $term . '%')
            ->orWhere('l_beschreibung', 'like', '%' . $term . '%')
            ->get();
    }

    /**
     * Returns the path of the page
     * @return string
     */
    public function path()
    {
        return route('location.show', $this);
    }

    public function getBuildings($locid)
    {
        $list = DB::select('SELECT * from buildings where locations_id=?', [$locid]);
        // dd($list);

        return count($list);

        // return $this->hasMany(Product::class);
        // return $list;
    }

    public function getequipment($equipmenttype = 1)
    {
        // gibt alle Geräte des Standortes zurück
        // mit $equipmenttype kann die Art der Geräte gefiltert werden
    }

    public function Profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function Adresse()
    {
        return $this->belongsTo(Adresse::class);
    }

    public function Building()
    {
        return $this->hasMany(Building::class);
    }

    public function LocationAnforderung()
    {
        return $this->hasMany(LocationAnforderung::class);
    }

    static function checkStatus()
    {
        if (rand(1, 3) === 1) {
            return '
                    <span class="sectionStatus">
                        Status <i class="fas fa-check-circle text-success"></i>
                    </span>
                    ';
        } elseif (rand(1, 3) === 2) {
            return '
                    <span class="sectionStatus">
                        Status <i class="fas fa-exclamation-circle text-warning"></i>
                    </span>
                    ';
        } else {
            return '
                    <span class="sectionStatus">
                        Status <i class="fas fa-times-circle text-danger"></i>
                    </span>
                    ';
        }
    }

    public function Storage()
    {
        return $this->hasOne(Storage::class, 'storage_uid', 'storage_id');
    }

    public function countTotalEquipmentInLocation()
    {
        return Cache::remember(
            'countTotalEquipmentInLocation'.$this->id,
            now()->addSeconds(30),
            function () {
                $equipCounter = 0;
                $equipCounter += ($this->Storage) ? $this->Storage->countReferencedEquipment() : 0;
                $buildings = \App\Building::where('location_id', $this->id)->get();
                foreach ($buildings as $building) {
                    $equipCounter += ($building->Storage) ? $building->Storage->countReferencedEquipment() : 0;
                    $rooms = Room::where('building_id', $building->id)->get();
                    foreach ($rooms as $room) {
                        $equipCounter += ($room->Storage) ? $room->Storage->countReferencedEquipment() :0;
                        $compartments = Stellplatz::where('room_id', $room->id)->get();
                        foreach ($compartments as $compartment) {
                            $equipCounter += ($compartment->Storage) ? $compartment->Storage->countReferencedEquipment() : 0;
                        }
                    }
                }
                return $equipCounter;
            }
        );
    }
}
