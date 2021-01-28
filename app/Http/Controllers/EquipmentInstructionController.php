<?php

namespace App\Http\Controllers;

use App\EquipmentInstruction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquipmentInstructionController extends Controller
{

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
        EquipmentInstruction::create($this->validateEquipmentInstruction());
        $request->session()->flash('status', __('Die Unterweisung wurde angelegt!'));
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateEquipmentInstruction()
    : array
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentInstruction $equipmentInstruction
     * @param  Request              $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(EquipmentInstruction $equipmentInstruction, Request $request)
    : RedirectResponse
    {
        $request->session()->flash('status', __('Die Unterweisung wurde gelöscht!'));
        $equipmentInstruction->delete();
        return redirect()->back();
    }
}
