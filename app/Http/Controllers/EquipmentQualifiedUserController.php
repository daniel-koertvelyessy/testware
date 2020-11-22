<?php

namespace App\Http\Controllers;

use App\EquipmentQualifieduser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EquipmentQualifiedUserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
//        dd($request);
        EquipmentQualifieduser::create($this->validateQualifiedUser());
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateQualifiedUser()
    : array {
        return request()->validate([
            'user_id'                   => 'required',
            'equipment_id'              => 'required',
            'equipment_qualified_date'  => 'date',
            'equipment_qualified_firma' => '',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  EquipmentQualifieduser $equipmentQualifieduser
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentQualifieduser $equipmentQualifieduser) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EquipmentQualifieduser $equipmentQualifieduser
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentQualifieduser $equipmentQualifieduser) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request                $request
     * @param  EquipmentQualifieduser $equipmentQualifieduser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EquipmentQualifieduser $equipmentQualifieduser) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request                $request
     * @param  EquipmentQualifieduser $equipmentQualifieduser
     * @return RedirectResponse
     */
    public function destroy(Request $request, EquipmentQualifieduser $equipmentQualifieduser) {
      EquipmentQualifieduser::find($request->id)->delete();
        $request->session()->flash('status', 'Die Zuordnung wurde gelöscht!');
        return redirect()->back();
    }
}
