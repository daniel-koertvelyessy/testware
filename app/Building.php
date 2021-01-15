<?php

namespace App;

use App\Stellplatz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;

class Building extends Model
{
    use SoftDeletes, Sortable;

    /**
     * Returns the path of the page
     *
     * @return string
     */

    protected $guarded = [];

    public $sortable = [
        'b_label',
        'b_name',
        'b_name_text',
    ];

    public static function boot()
    {
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

    public function search($term)
    {
        return Building::where('b_label', 'like', '%' . $term . '%')->orWhere('b_name_ort', 'like', '%' . $term . '%')->orWhere('b_name', 'like', '%' . $term . '%')->orWhere('b_name_text', 'like', '%' . $term . '%')->orWhere('b_we_name', 'like', '%' . $term . '%')->get();
    }

    public function path()
    {
        return route('building.show', $this);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function BuildingType()
    {
        return $this->belongsTo(BuildingTypes::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'building_id');
    }

    public function countStellPlatzs(Building $building)
    {
        $n = 0;
        foreach ($building->rooms->pluck('id') as $rid) {
            $n += count(Stellplatz::where('room_id', $rid)->get());
        }
        return $n;
    }

    public function Storage()
    {
        return $this->hasOne(Storage::class, 'storage_uid', 'storage_id');
    }

    public function countTotalEquipmentInBuilding()
    {
        Cache::remember('countTotalEquipmentInBuilding'.$this->id, now()->addSeconds(30), function () {
            $equipCounter = 0;
            $equipCounter += ($this->Storage) ? $this->Storage->countReferencedEquipment() :0;
            $rooms = Room::where('building_id', $this->id)->get();
            foreach ($rooms as $room) {
                $equipCounter += ($room->Storage) ? $room->Storage->countReferencedEquipment() :0;
                $compartments = Stellplatz::where('room_id', $room->id)->get();
                foreach ($compartments as $compartment) {
                    $equipCounter += ($compartment->Storage) ? $compartment->Storage->countReferencedEquipment() :0;
                }
            }
            return $equipCounter;
        });
    }

    public function add($data)
    {
        $this->b_label = $data['label'];
        $this->b_name = (isset($data['name'])) ? $data['name'] : null;
        $this->b_name_text = (isset($data['description'])) ? $data['description'] : null;
        $uid = (isset($data['uid'])) ? $data['uid'] : Str::uuid();
        (new Storage)->add($uid, $data['label'], 'buildings');
        $this->storage_id = $uid;
        $this->location_id = 1;
        $this->building_type_id = 1;
        $this->save();
        return $this->id;
    }
}
