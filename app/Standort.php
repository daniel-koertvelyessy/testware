<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standort extends Model
{
    public function add($stid, $kurzel, $typ) {
        $sd = new Standort();
        $sd->std_objekt_typ = $typ;
        $sd->std_id = $stid;
        $sd->std_kurzel = $kurzel;
        return $sd->save();

    }

    public function remove($id) {
        return Standort::find($id)->delete();
    }
}
