<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentDoc extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static function addReport($equip_id, $filename, $reportID)
    {
        $proDocFile = new EquipmentDoc();
        $proDocFile->eqdoc_name = $filename;
        $proDocFile->eqdoc_name_pfad = 'equipment_docu/' . $equip_id . '/' . $filename;
        $proDocFile->document_type_id = 4;
        $proDocFile->equipment_id = $equip_id;


        if (EquipmentDoc::where('eqdoc_label', $reportID)->count() === 0) {
            $proDocFile->eqdoc_label = $reportID;
            $proDocFile->save();
        }
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function DocumentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function getSize($file)
    {
        //        $size = Storage::zs
        return helpers::fileSizeForHumans(Storage::size($file));
    }

    public function url($pfad)
    {
        return Storage::url($pfad);
    }

    public function addDocument(Request $request)
    {
        $file = $request->file('controlDokumentFile');
        $this->eqdoc_name = $file->getClientOriginalName();
        $eqdoc_name_pfad = $file->store('equipment_files/' . \request('equipment_id'));
        $this->eqdoc_name_pfad = $eqdoc_name_pfad;
        $this->document_type_id = request('document_type_id');
        $this->equipment_id = request('equipment_id');
        $this->eqdoc_description = request('eqdoc_description');
        $this->eqdoc_label = request('eqdoc_label');
        $this->save();
        return $eqdoc_name_pfad;
    }
}
