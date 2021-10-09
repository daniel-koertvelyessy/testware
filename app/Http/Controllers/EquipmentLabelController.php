<?php

namespace App\Http\Controllers;

use App\EquipmentLabel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class EquipmentLabelController extends Controller
{
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
     * @return RedirectResponse
     */
    public function store(Request $request)
    : RedirectResponse {
        if (isset($request->id)) {
            $msg = ($this->update($request, EquipmentLabel::find($request->id))) ? __('Das Label wurde aktualisiert') : __('Das Label konnte nicht aktualisiert werden');
        }elseif ((new EquipmentLabel)->add($request)) {
            $msg = __('Das Label wurde gespeichert');
        } else {
            $msg = __('Ein Fehler ist beim Speichern passiert!');
            Log::warning('error on saving a new label');
        }
        $request->session()->flash('status', $msg);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  EquipmentLabel  $equipmentlabel
     *
     * @return bool
     */
    public function update(Request $request, EquipmentLabel $equipmentlabel)
    {
       return $equipmentlabel->update($this->validateEquipmentLabel());
    }

    /**
     * Display the specified resource.
     *
     * @param  EquipmentLabel  $equipmentlabel
     *
     * @return Response
     */
    public function show(EquipmentLabel $equipmentlabel)
    {
        echo $equipmentlabel;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EquipmentLabel  $equipmentlabel
     *
     * @return Response
     */
    public function edit(EquipmentLabel $equipmentlabel)
    {
        dd($equipmentlabel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentLabel  $equipmentlabel
     *
     * @return Response
     */
    public function destroy(EquipmentLabel $equipmentlabel)
    {
        //
    }

    /**
     * @return array
     */
    public function validateEquipmentLabel()
    : array
    {
        return request()->validate([
//            'eq_inventar_nr'     => [
//                'bail',
//                'max:100',
//                'required',
//                Rule::unique('equipment')->ignore(request('id'))
//            ],

'label'          => 'required|max:20', 'name' => 'max:100',
'show_labels'    => '', 'show_inventory' => '',
'show_location'  => '', 'label_w' => '', 'Label_h' => '',
'label_ml'       => '', 'label_mt' => '', 'label_mr' => '', 'qrcode_y' => '',
'qrcode_x'       => '', 'logo_y' => '', 'logo_x' => '', 'logo_h' => '',
'logo_w'         => '', 'logo_svg' => ''
        ]);
    }
}
