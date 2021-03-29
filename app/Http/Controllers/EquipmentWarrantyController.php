<?php

namespace App\Http\Controllers;

use App\EquipmentWarranty;
use Illuminate\Http\Request;

class EquipmentWarrantyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EquipmentWarranty  $equipmentWarranty
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentWarranty $equipmentWarranty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EquipmentWarranty  $equipmentWarranty
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentWarranty $equipmentWarranty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EquipmentWarranty  $equipmentWarranty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EquipmentWarranty $equipmentWarranty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EquipmentWarranty  $equipmentWarranty
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentWarranty $equipmentWarranty)
    {
        //
    }
}
