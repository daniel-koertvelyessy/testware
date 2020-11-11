<?php

namespace App\Http\Controllers;

use App\EquipmentInstruction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquipmentInstructionController extends Controller {


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {

        EquipmentInstruction::create($this->validateEquipmentInstruction());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EquipmentInstruction $equipmentInstruction
     * @return Response
     */
    public function show(EquipmentInstruction $equipmentInstruction) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EquipmentInstruction $equipmentInstruction
     * @return Response
     */
    public function edit(EquipmentInstruction $equipmentInstruction) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request                   $request
     * @param  \App\EquipmentInstruction $equipmentInstruction
     * @return Response
     */
    public function update(Request $request, EquipmentInstruction $equipmentInstruction) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EquipmentInstruction $equipmentInstruction
     * @return Response
     */
    public function destroy(EquipmentInstruction $equipmentInstruction) {
        //
    }

    /**
     * @return array
     */
    public function validateEquipmentInstruction(): array
    {
        return request()->validate([
            'equipment_instruction_date' => 'bail|required|date',
            'equipment_instruction_instructor_signature' => '',
            'equipment_instruction_instructor_profile_id' => '',
            'equipment_instruction_instructor_firma_id' => '',
            'equipment_instruction_trainee_signature' => '',
            'equipment_instruction_trainee_id' => 'required',
            'equipment_id' => 'required'
        ]);
    }
}
