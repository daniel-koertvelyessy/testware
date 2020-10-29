<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EquipmentDoc extends Model {
    public static function addReport($equip_id, $filename, $reportID) {
        $proDocFile = new EquipmentDoc();
        $proDocFile->eqdoc_name_lang = $filename;
        $proDocFile->eqdoc_name_pfad = 'equipment_docu/' . $equip_id . '/' . $filename;
        $proDocFile->document_type_id = 4;
        $proDocFile->equipment_id = $equip_id;



        if (EquipmentDoc::where('eqdoc_name_kurz', $reportID)->count()===0 ) {
            $proDocFile->eqdoc_name_kurz = $reportID;
            $proDocFile->save();
        }
    }

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function DocumentType() {
        return $this->belongsTo(DocumentType::class);
    }

    public function getSize($file) {
//        $size = Storage::zs
        return number_format(Storage::size($file) / 1028, 1, ',', '.');
    }

    public function url($pfad) {
        return Storage::url($pfad);
    }

}
