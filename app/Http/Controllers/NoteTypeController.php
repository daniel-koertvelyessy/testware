<?php

namespace App\Http\Controllers;

use App\NoteType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NoteTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return NoteType
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse
    {
        NoteType::create($this->validateNewNoteType());
        $request->session()->flash('status', __('Notiztyp angelegt'));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  NoteType $note_type
     *
     * @return NoteType
     */
    public function show(NoteType $note_type)
    : NoteType
    {
        return $note_type;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  NoteType $note_type
     *
     * @return Response
     */
    public function edit(NoteType $note_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  NoteType $note_type
     *
     * @return RedirectResponse
     */
    public function update(Request $request, NoteType $note_type)
    : RedirectResponse
    {
        $note_type->update(request()->validate([
            'label'       => 'required',
            'name'        => '',
            'description' => '',
        ]));
        $request->session()->flash('status', __('Notiztyp aktualisiert!'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  NoteType $note_type
     *
     * @return Response
     */
    public function destroy(NoteType $note_type)
    {
        //

    }

    /**
     * @return array
     */
    public function validateNewNoteType()
    : array
    {
        return request()->validate([
            'label'       => 'bail|unique:note_types,label|required',
            'name'        => '',
            'description' => '',
        ]);
    }
}
