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
        $request->session()->flash('status', __('Die Unterweisung wurde angelegt!'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request) {
        $request->session()->flash('status', __('Die Unterweisung wurde gelöscht!'));
        EquipmentInstruction::find($request->id)->delete();
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateEquipmentInstruction()
    : array {
        return request()->validate([
            'equipment_instruction_date'                  => 'bail|required|date',
            'equipment_instruction_instructor_signature'  => '',
            'equipment_instruction_instructor_profile_id' => '',
            'equipment_instruction_instructor_firma_id'   => '',
            'equipment_instruction_trainee_signature'     => '',
            'equipment_instruction_trainee_id'            => 'required',
            'equipment_id'                                => 'required'
        ]);
    }
}
