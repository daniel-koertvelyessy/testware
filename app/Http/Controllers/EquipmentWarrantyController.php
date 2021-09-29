<?php

namespace App\Http\Controllers;

use App\EquipmentWarranty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquipmentWarrantyController extends Controller
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
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  EquipmentWarranty  $equipmentWarranty
     *
     * @return Response
     */
    public function show(EquipmentWarranty $equipmentWarranty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EquipmentWarranty  $equipmentWarranty
     *
     * @return Response
     */
    public function edit(EquipmentWarranty $equipmentWarranty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  EquipmentWarranty  $equipmentWarranty
     *
     * @return Response
     */
    public function update(Request $request, EquipmentWarranty $equipmentWarranty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentWarranty  $equipmentWarranty
     *
     * @return Response
     */
    public function destroy(EquipmentWarranty $equipmentWarranty)
    {
        //
    }
}
