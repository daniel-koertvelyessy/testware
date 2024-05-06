<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\Fluent\Concerns\Has;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Storage extends Model
{
    use SoftDeletes, Sortable, HasFactory;

    public $sortable = [
        'id',
        'storage_label',
        'storage_uid',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::updating(function () {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
    }

    public function getStoragePath()
    {

        switch ($this->storage_object_type) {

            case 'locations':
                $loc = Location::where('storage_id', $this->storage_uid)->first();
                return ($loc) ? $loc->l_label . ' - ' . $loc->l_name : 'loc - ' . $this->storage_label;

            case 'buildings':
                $bul = Building::where('storage_id', $this->storage_uid)->first();
                return ($bul) ? $bul->b_label . ' - ' . $bul->b_name : 'bul - ' . $this->storage_label;

            case 'rooms':
                $room = Room::where('storage_id', $this->storage_uid)->first();
                return ($room) ? $room->r_label . ' - ' . $room->r_name : 'rom - ' . $this->storage_label;

            case 'stellplatzs':
                $spl = Stellplatz::where('storage_id', $this->storage_uid)->first();
                return ($spl) ? $spl->sp_label . ' - ' . $spl->sp_name : 'com - ' . $this->storage_label;

            default:
                return $this->storage_label;
        }

    }

    public static function getLocationPath($uid)
    {
        $path = '';
        $stdid = Storage::find($uid);

        $table = $stdid->storage_object_type;

        switch ($table) {

            case 'locations':

                $loc = Location::where('storage_id', $stdid->storage_uid)->first();
                $path = __('Standort') . ': ' . $loc->l_label;
                break;

            case 'buildings':

                $bul = Building::where('storage_id', $stdid->storage_uid)->first();

                $loc = Location::where('id', $bul->location_id)->first();

                $path = __('Standort') . ': ' . $loc->l_label . ' > ' . __('Gebäude') . ': ' . $bul->b_label;
                break;

            case 'rooms':

                $rom = Room::where('storage_id', $stdid->storage_uid)->first();


                $bul = Building::find($rom->building_id);


                $loc = Location::find($bul->location_id);


                $path = __('Standort') . ': ' . $loc->l_label . ' > ' . __('Gebäude') . ':' . ' ' . $bul->b_label . ' > ' . __('Raum') . ':' . ' ' . $rom->r_label;

                break;

            case 'stellplatzs':

                $spl = Stellplatz::where('storage_id', $stdid->storage_uid)->first();

                $rom = Room::find($spl->id)->first();

                $bul = Building::find($rom->building_id)->first();


                $loc = Location::find($bul->location_id)->first();


                $path = __('Standort') . ': ' . $loc->l_label . ' > ' . __('Gebäude') . ':' . ' ' . $bul->b_label . ' > ' . __('Raum') . ':' . ' ' . $rom->r_label . ' > ' . __('Stellplatz') . ':' . ' ' . $spl->sp_label;

                break;
        }

        return $path;
    }

    public function checkUpdate($uid, $label)
    {
        $storage = Storage::where('storage_uid', $uid)->first();
        $storage->storage_label = $label;
        $storage->save();
    }

    /**
     * @param $uid string 'UUID
     * @param $label string 'Label'
     * @param $type string 'Typ: locations, '
     * @return int|mixed
     */
    public function change($uid, $label, $type)
    {
        return $this->add($uid, $label, $type);
    }

    public function add($uid, $label, $type)
    {
        $storageByLabel = Storage::where('storage_label', $label)->first();
        if (!$storageByLabel) {
            $storageByUid = Storage::where('storage_uid', $uid)->first();
            if (!$storageByUid) {
                $storage = new Storage();
                $storage->storage_object_type = $type;
                $storage->storage_uid = $uid;
                $storage->storage_label = $label;
                $storage->save();
                return $storage->id;
            } else {
                $storageByUid->storage_object_type = $type;
                $storageByUid->storage_uid = $uid;
                $storageByUid->storage_label = $label;
                $storageByUid->save();
                return $storageByUid->id;
            }
        } else {
            $storageByLabel->storage_object_type = $type;
            $storageByLabel->storage_uid = $uid;
            $storageByLabel->storage_label = $label;
            $storageByLabel->save();
            return $storageByLabel->id;
        }
    }

    public function remove()
    {
        return $this->delete();
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'storage_id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function compartment()
    {
        return $this->belongsTo(Stellplatz::class);
    }

    public function countReferencedEquipment()
    {
        return Equipment::where('storage_id', $this->id)->count();
    }

    public function checkUidExists($uid)
    {
        return Storage::where('storage_uid', $uid)->count() > 0;
    }
}
