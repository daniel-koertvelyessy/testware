<?php

namespace App\Http\Controllers;

use App\Note;
use App\NoteType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * @return Response
     */
    public function store(Request $request)
    {



        if($request->note_type_id === 'new' && !empty($request->newNoteType)){
            (new NoteType)->addType($request);
        }

        dd();
       if($request->hasFile('file_path')){
           $request->validate([
               'file_path' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:10240',
               // size:2048 => 2048kB
               'uid'       => 'required'
           ]);
           $file = $request->file('file_path');
           $request->file_name = $file->getClientOriginalName();
           $request->file_path = $file->store('notes/' .$request->uid .'/' );
       }



        Note::create(request()->validate([
            'uid'       => 'required',
            'label'        => 'required',
            'description' => '',
            'note_type_id' => '',
            'is_intern' => '',
            'file_path' => '',
            'file_name' => '',
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note $objectNote
     *
     * @return Response
     */
    public function show(Note $objectNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note $objectNote
     *
     * @return Response
     */
    public function edit(Note $objectNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request   $request
     * @param  \App\Note $objectNote
     *
     * @return Response
     */
    public function update(Request $request, Note $objectNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $objectNote
     *
     * @return Response
     */
    public function destroy(Note $objectNote)
    {
        //
    }
}
