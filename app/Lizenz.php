<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lizenz extends Model
{
    static function checkNumObjectsOverflow(){
        $flag = (Lizenz::getNumObjekte() >= config('app.maxobjekte'))  ;
        session('objektemake', $flag);
        return $flag;

    }

    public static function getNumObjekte()
    {
        $num = Location::all()->count();
        $num += Building::all()->count();
        $num += Room::all()->count();
        $num += Equipment::all()->count();

        return $num;
    }

}
