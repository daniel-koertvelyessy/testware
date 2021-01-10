<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Storage extends Model
{
    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'storage_label',
        'storage_uid',
    ];

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

    public function change($uid, $label, $type)
    {
        return $this->add($uid, $label, $type);
    }

    public function remove()
    {
        return $this->delete();
    }

    public static function getLocationPath($uid)
    {
        $path = '';
        $stdid = Storage::find($uid);

        $table = $stdid->storage_object_type;

        switch ($table) {

            case 'locations':

                $loc = Location::where('storage_id', $stdid->storage_uid);
                $path = __('Standort') . ': ' . $loc->l_label;
                break;

            case 'buildings':

                $bul = Building::where('storage_id', $stdid->storage_uid);

                $loc = Location::where('id', $bul->location_id);

                $path = __('Standort') . ': ' . $loc->l_label . ' > ' . __('Gebäude') . ': ' . $bul->b_label;
                break;

            case 'rooms':

                $rom = Room::where('storage_id', $stdid->storage_uid)->get();


                $bul = Building::find($rom[0]->building_id);


                $loc = Location::find($bul->location_id);


                $path = __('Standort') . ': ' . $loc->l_label .
                    ' > ' . __('Gebäude') . ':' . ' ' . $bul->b_label .
                    ' > ' . __('Raum') . ':' . ' ' . $rom[0]->r_label;

                break;

            case 'stellplatzs':

                $spl = Stellplatz::where('storage_id', $stdid->storage_uid)->get();

                $rom = Room::find($spl->id)->get();

                $bul = Building::find($rom[0]->building_id);


                $loc = Location::find($bul->location_id);


                $path = __('Standort') . ': ' . $loc->l_label .
                    ' > ' . __('Gebäude') . ':' . ' ' . $bul->b_label .
                    ' > ' . __('Raum') . ':' . ' ' . $rom->r_label .
                    ' > ' . __('Stellplatz') . ':' . ' ' . $spl[0]->sp_label;

                break;
        }

        return $path;
    }

    public function Equipment()
    {
        return $this->belongsTo(Equipment::class);
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
}
