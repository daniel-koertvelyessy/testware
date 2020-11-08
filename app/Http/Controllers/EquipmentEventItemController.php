<?php

namespace App\Http\Controllers;

use App\EquipmentEventItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquipmentEventItemController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {
        EquipmentEventItem::create($this->validateEquipmentEventItem());
        $request->session()->flash('status', 'Die Meldung wurde angelegt!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  EquipmentEventItem $equipmenteventitem
     * @return Response
     */
    public function show(EquipmentEventItem $equipmenteventitem) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EquipmentEventItem $equipmenteventitem
     * @return Response
     */
    public function edit(EquipmentEventItem $equipmenteventitem) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request            $request
     * @param  EquipmentEventItem $equipmenteventitem
     * @return RedirectResponse
     */
    public function update(Request $request, EquipmentEventItem $equipmenteventitem) {
        $equipmenteventitem->update($this->validateEquipmentEventItem());
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateEquipmentEventItem()
    : array {
        return request()->validate([
            'equipment_event_item_text' => '',
            'user_id'                   => '',
            'equipment_event_id'        => 'required',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentEventItem $equipmenteventitem
     * @return Response
     */
    public function destroy(EquipmentEventItem $equipmenteventitem) {
        //
    }
}
