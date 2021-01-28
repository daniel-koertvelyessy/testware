<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentQualifiedUser;
use App\ProductQualifiedUser;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductQualifiedUserController extends Controller
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
        ProductQualifiedUser::create($this->validateQualifiedUser());
        $countAddedQualifiedEquipmentUser = 0;
        foreach (Equipment::where('produkt_id', $request->produkt_id)->get() as $equipment) {
            $countAddedQualifiedEquipmentUser += (new EquipmentQualifiedUser)->addQualifiedUser($request, $equipment);
        }

        $request->session()->flash('status', __('Befähigte Person hinzugefügt. Es wurden :num Geräte aktualisiert', ['num' => $countAddedQualifiedEquipmentUser]));

        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateQualifiedUser()
    : array
    {
        return request()->validate([
            'user_id'                 => 'required',
            'produkt_id'              => 'required',
            'product_qualified_date'  => 'date',
            'product_qualified_firma' => '',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request              $request
     * @param  ProductQualifiedUser $ProductQualifiedUser
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, ProductQualifiedUser $ProductQualifiedUser)
    : RedirectResponse
    {
        $countRemovedQualifiedEquipmentUser = 0;
        foreach (Equipment::where('produkt_id', $ProductQualifiedUser->produkt_id)->get() as $equipment) {
            $countRemovedQualifiedEquipmentUser +=  (new EquipmentQualifiedUser)->removeQualifiedUser($ProductQualifiedUser->user_id, $equipment);
        }
        $ProductQualifiedUser->delete();
        $request->session()->flash('status', __('Befähigung wurde entzogen. Es wurden :num Geräte aktualisiert', ['num' => $countRemovedQualifiedEquipmentUser]));
        return redirect()->back();
    }
}
