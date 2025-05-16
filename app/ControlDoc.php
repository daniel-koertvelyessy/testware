<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ControlDoc extends Model
{
    use SoftDeletes;

    public function ControlEvent()
    {
        return $this->belongsToMany(ControlEvent::class);
    }

    public function addDocument(Request $request)
    {
        $request->validate([
            'controlDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:20480',
            'eqdoc_label' => 'required|unique:equipment_docs,eqdoc_label',
        ]);

        $file = $request->file('controlDokumentFile');

        $eqdoc_name_pfad = (new EquipmentDoc)->addDocument($request);

        $this->control_event_doc_label = $request->eqdoc_label;
        $this->control_event_doc_name = $file->getClientOriginalName();
        $this->control_event_doc_name_pfad = $eqdoc_name_pfad;
        $this->control_event_id = $request->control_equipment_id;
        $this->save();

        return $file->getClientOriginalName();
    }
}
