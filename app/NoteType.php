<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NoteType extends Model
{
    protected $guarded = [];

    /**
     * @note store new NoteType from AddNote-Modal given only
     *       a label. If db-entry with label is present return
     *       this entry id
     */
    public function addType(Request $request): int
    {
        $noteType = NoteType::where('label', $request->newNoteType)->count();
        if ($noteType > 0) {
            return NoteType::where('label', $request->newNoteType)->first()->id;
        }
        $this->label = $request->newNoteType;
        $this->save();

        return $this->id;
    }

    /**
     * @note store new NoteType from admin-section given a full
     *       dtaset. If db-entry with label is present return
     *       this entry id.
     *
     * @todo Add respective form to admin section for backend
     */
    public function addFullType(Request $request): int
    {
        $request->validate([
            'label' => [
                'required',
                Rule::unique('note_types')->ignore($request->id),
            ],
        ]);
        $this->label = $request->newNoteType;
        $this->name = $request->name ?? null;
        $this->description = $request->description ?? null;
        $this->save();

        return $this->id;
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class);
    }
}
