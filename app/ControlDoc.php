<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ControlDoc extends Model
{
    Use SoftDeletes;

    public function ControlEvent()
    {
        return $this->belongsToMany(ControlEvent::class);
    }

    public function addDocument(Request $request)
    {
        $request->validate([
            'controlDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:10240',
            'eqdoc_label'         => 'required|unique:equipment_docs,eqdoc_label'
        ]);

        $file = $request->file('controlDokumentFile');

        $this->eqdoc_name = $file->getClientOriginalName();
        $this->eqdoc_name_pfad = $file->store('equipment_docu/' . \request('equipment_id'));
        $this->document_type_id = request('document_type_id');
        $this->equipment_id = request('equipment_id');
        $this->eqdoc_description = request('eqdoc_description');
        $this->eqdoc_label = request('eqdoc_label');

        $this->save();
        $filename = $file->getClientOriginalName();

        $this->control_event_doc_label = $request->control_event_doc_label;
        $this->control_event_doc_name = $request->aa;
        $this->control_event_doc_name_pfad = $request->aa;
        $this->control_event_id = $request->aa;
        $this->save();

        return $file->getClientOriginalName();
    }
}
