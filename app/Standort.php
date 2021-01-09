<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Standort extends Model
{
    use SoftDeletes ,Sortable;

    public $sortable = [
        'id',
        'std_kurzel',
        'std_id',
    ];

    public function add($uid, $label, $type) {
        $standortByLabel = Standort::where('std_kurzel',$label)->first();
        if(!$standortByLabel){
            $standortByUid = Standort::where('std_id',$uid)->first();
            if (!$standortByUid){
                $standort = new Standort();
                $standort->std_objekt_typ = $type;
                $standort->std_id = $uid;
                $standort->std_kurzel = $label;
                $standort->save();
                return $standort->id;
            } else {
                $standortByUid->std_objekt_typ = $type;
                $standortByUid->std_id = $uid;
                $standortByUid->std_kurzel = $label;
                $standortByUid->save();
                return $standortByUid->id;
            }
        } else {
            $standortByLabel->std_objekt_typ = $type;
            $standortByLabel->std_id = $uid;
            $standortByLabel->std_kurzel = $label;
            $standortByLabel->save();
            return $standortByLabel->id;
        }
    }

    public function change($uid, $label, $type) {
       return $this->add($uid, $label, $type);
    }

    public function remove() {
        return $this->delete();
    }

    public static function getLocationPath($uid)
    {
        $path = '';
        $stdid = Standort::find($uid);

        $table = $stdid->std_objekt_typ;

        switch ($table)
        {

            case'locations':

                $loc = Location::where('standort_id',$stdid->std_id);
                $path = __('Standort') . ': ' . $loc->l_name_kurz;
                break;

            case'buildings':

                $bul = Building::where('standort_id',$stdid->std_id);

                $loc = Location::where('id',$bul->location_id);

                $path = __('Standort') . ': ' . $loc->l_name_kurz . ' > '. __('Gebäude').': ' . $bul->b_name_kurz;
                break;

            case'rooms':

                $rom = Room::where('standort_id',$stdid->std_id)->get();


                $bul = Building::find($rom[0]->building_id);


                $loc = Location::find($bul->location_id);


                $path = __('Standort') . ': ' . $loc->l_name_kurz .
                        ' > '. __('Gebäude').':' . ' ' . $bul->b_name_kurz .
                        ' > '. __('Raum').':' . ' ' . $rom[0]->r_name_kurz ;

                break;

            case'stellplatzs':

                $spl = Stellplatz::where('standort_id',$stdid->std_id)->get();

                $rom = Room::find($spl->id)->get();

                $bul = Building::find($rom[0]->building_id);


                $loc = Location::find($bul->location_id);


                $path = __('Standort') . ': ' . $loc->l_name_kurz .
                    ' > '. __('Gebäude').':' . ' ' . $bul->b_name_kurz .
                    ' > '. __('Raum').':' . ' ' . $rom->r_name_kurz .
                    ' > '. __('Stellplatz').':' . ' ' . $spl[0]->sp_name_kurz ;

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
        return $this->belongsTo(Location::class,'standort_id');
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

    public function countReferencedEquipment() {
        return Equipment::where('standort_id',$this->id)->count();
    }

}
