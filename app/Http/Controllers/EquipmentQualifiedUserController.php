<?php

namespace App\Http\Controllers;


use App\EquipmentHistory;
use App\EquipmentQualifiedUser;
use App\Firma;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EquipmentQualifiedUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        $company = Firma::find($request->equipment_qualified_firma);
        (new EquipmentHistory)->add(
            __('Befähigte Person hinzugefügt'),
            $user->name . __(' wurde am :inDate durch die Firma :companyName als befähigte Person qualifiziert.',['inDate'=> $request->equipment_qualified_date, 'companyName'=>$company->fa_name]),
            $request->equipment_id
        );

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
     * @param  EquipmentQualifiedUser $EquipmentQualifiedUser
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, EquipmentQualifieduser $EquipmentQualifiedUser)
    : RedirectResponse
    {
        (new EquipmentHistory)->add(
            __('Qualifizierung entzogen'),
            $EquipmentQualifiedUser->user->name . __(' wurde am :inDate als befähigte Person entfernt.',['inDate'=> date('Y-m-d')]),
            $EquipmentQualifiedUser->equipment_id
        );

        $EquipmentQualifiedUser->delete();
        $request->session()->flash('status', 'Die Zuordnung wurde gelöscht!');
        return redirect()->back();
    }
}
