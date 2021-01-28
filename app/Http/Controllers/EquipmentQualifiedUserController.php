<?php

namespace App\Http\Controllers;


use App\EquipmentQualifiedUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EquipmentQualifiedUserController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
//        dd($request);
        EquipmentQualifiedUser::create($this->validateQualifiedUser());
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateQualifiedUser()
    : array
    {
        return request()->validate([
            'user_id'                   => 'required',
            'equipment_id'              => 'required',
            'equipment_qualified_date'  => 'date',
            'equipment_qualified_firma' => '',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request                $request
     * @param  EquipmentQualifieduser $equipmentQualifieduser
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, EquipmentQualifieduser $equipmentQualifieduser)
    {
        EquipmentQualifieduser::find($request->id)->delete();
        $request->session()->flash('status', 'Die Zuordnung wurde gelöscht!');
        return redirect()->back();
    }
}
