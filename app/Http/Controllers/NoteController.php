<?php

namespace App\Http\Controllers;

use App\Note;
use App\NoteType;
use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): array
    {
        $note = Note::find($request->id);
        $data['data'] = $note;
        $data['title'] = __('Notiz bearbeiten');
        $data['tags'] = '';
        foreach ($note->tags()->get() as $tag) {
            $data['tags'] .= ' <div class="alert alert-'.$tag->color.' alert-dismissible fade show" role="alert">
          '.$tag->label.'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <input type="hidden" name="tag[]" id="note_tag_'.$tag->id.'" value="'.$tag->id.'">
        </div>';
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        if ($request->note_type_id === 'new' && ! empty($request->newNoteType)) {
            $request->note_type_id = (new NoteType)->addType($request);
        }

        if ($request->hasFile('file_path')) {
            $request->validate([
                'file_path' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:20480',
                // size:2048 => 2048kB
                'uid' => 'required',
            ]);
            $file = $request->file('file_path');
            $request->file_name = $file->getClientOriginalName();
            $request->file_path = $file->store('notes/'.$request->uid.'/');
        }

        (new Note)->addNote($request);

        return back();

    }

    /**
     * Display the specified resource.
     *
     *
     * @throws Throwable
     */
    public function show(Note $note): array
    {
        $data['html'] = view('components.note-detail', ['note' => $note])->render();

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note): RedirectResponse
    {
        if (Auth::user()->id === $request->user_id) {
            $note->update($request->validate([
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
            ]));

            if (isset($request->tag)) {
                $note->tags()->sync($request->tag);
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Note $note): RedirectResponse
    {
        if (Auth::user()->id === $note->user_id || Auth::user()->isSysAdmin()) {
            $msg = $note->delete() ? __('Notiz gelöscht') : __('Notiz konnte nicht gelöscht werden');
        } else {
            $msg = __('Sie dürfen diese Notiz nicht löschen.');
        }
        session()->flash('status', $msg);

        return back();
    }

    public function downloadNotesFile(Request $request)
    {

        $note = Note::findOrFail($request->id);

        return response(Storage::disk('local')->get($note->file_path), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', Storage::mimeType($note->file_path))
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', 'attachment; filename='.str_replace(',', '_', $note->file_name));
    }
}
