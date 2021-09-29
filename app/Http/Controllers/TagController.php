<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
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
     * @return array
     */
    public function store(Request $request)
    : array
    {
        $tagid = (new Tag)->addNew($request);
        $data['html'] = '
        <div class="alert alert-'.$request->color.' alert-dismissible fade show" role="alert">
          '.$request->name.'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <input type="hidden" name="tag[]" id="note_tag_'.$tagid.'" value="'.$tagid.'">
        </div>';
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  Tag  $tag
     *
     * @return Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag  $tag
     *
     * @return Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Tag $tag
     *
     * @return Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag  $tag
     *
     * @return Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
