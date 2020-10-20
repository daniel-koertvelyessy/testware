<?php

namespace App\Http\Controllers;

use App\AnforderungControlItem;
use http\Client\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnforderungControlItemController extends Controller {

    use SoftDeletes;

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index() {
        return view('admin.verordnung.anforderungitem.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create() {
        return view('admin.verordnung.anforderungitem.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  AnforderungControlItem $anforderungcontrolitem
     * @return Application|Factory|Response|View
     */
    public function show(AnforderungControlItem $anforderungcontrolitem) {
        return view('admin.verordnung.anforderungitem.show', ['anforderungcontrolitem' => $anforderungcontrolitem]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request                $request
     * @param  AnforderungControlItem $anforderungcontrolitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnforderungControlItem $anforderungcontrolitem) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AnforderungControlItem $anforderungcontrolitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnforderungControlItem $anforderungcontrolitem) {
        //
    }
}
