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

    public function add($stid, $kurzel, $typ) {
        $sd = new Standort();
        $sd->std_objekt_typ = $typ;
        $sd->std_id = $stid;
        $sd->std_kurzel = $kurzel;
        return $sd->save();
    }

    public function change($stid, $kurzel, $typ) {
        $sd = Standort::where('std_id',$stid)->first();
        $sd->std_objekt_typ = $typ;
        $sd->std_id = $stid;
        $sd->std_kurzel = $kurzel;
        return $sd->save();
    }
    public function remove($id) {
        return Standort::find($id)->delete();
    }

    public static function getLocationPath($std_id)
    {
        $path = '';
        $stdid = Standort::find($std_id);

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
