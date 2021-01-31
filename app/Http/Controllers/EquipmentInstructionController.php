<?php

namespace App\Http\Controllers;

use App\EquipmentHistory;
use App\EquipmentInstruction;
use App\User;
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
        $user = User::find($request->equipment_instruction_trainee_id);

        (new EquipmentHistory)->add(
            __('Neue Unterweisung erfolgt'),
            $user->name . __(' wurde am :inDate in das Gerät eingewiesen.',['inDate'=> $request->equipment_instruction_date]),
            $request->equipment_id
        );

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
     * @param  EquipmentInstruction $EquipmentInstruction
     * @param  Request              $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(EquipmentInstruction $EquipmentInstruction, Request $request)
    : RedirectResponse
    {
        (new EquipmentHistory)->add(
            __('Unterweisung gelöscht'),
            $EquipmentInstruction->user->name . __(' wurde am :inDate aus der Lister der unterwiesenen Personen gelöscht.',['inDate'=> date('Y-m-d')]),
            $EquipmentInstruction->equipment_id
        );

        $request->session()->flash('status', __('Die Unterweisung wurde gelöscht!'));
        $EquipmentInstruction->delete();
        return redirect()->back();
    }
}
