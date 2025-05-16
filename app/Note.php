<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Note extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'note_tag')->withTimestamps();
    }

    public function addNote(Request $request): int
    {
        $request->validate([
            'label' => [
                'required',
                Rule::unique('note_types')->ignore($request->id),
            ],
            'uid' => 'required',
            'description' => '',
            'note_type_id' => 'required',
            'is_intern' => '',
            'file_name' => '',
            'file_path' => '',
            'user_id' => 'required',
        ]);

        $this->uid = $request->uid;
        $this->label = $request->label;
        $this->description = $request->description;
        $this->note_type_id = $request->note_type_id;
        $this->is_intern = $request->is_intern ?? 0;
        $this->user_id = $request->user_id;
        $this->file_name = $request->file_name;
        $this->file_path = $request->file_path;
        $this->save();

        if (isset($request->tag)) {

            $this->tags()->sync($request->tag);
        }

        return $this->id;
    }

    /**
     * @return int
     */
    public function updateNote(Request $request)
    {
        $request->validate([
            'label' => [
                'required',
                Rule::unique('note_types')->ignore($request->id),
            ],
            'uid' => 'required',
            'description' => '',
            'note_type_id' => 'required',
            'is_intern' => '',
            'user_id' => 'required',
        ]);
        $note = Note::find($request->id);

        $note->uid = $request->uid;
        $note->label = $request->label;
        $note->description = $request->description;
        $note->note_type_id = $request->note_type_id;
        $note->is_intern = $request->is_intern ?? 0;
        $note->user_id = $request->user_id;
        $note->save();
        if (isset($request->tag)) {

            $this->tags()->sync($request->tag);
        }

        return $this->id;
    }
}
