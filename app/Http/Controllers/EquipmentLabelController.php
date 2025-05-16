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
     */
    public function store(Request $request): RedirectResponse
    {

        if (isset($request->id)) {
            $msg = ($this->update($request, EquipmentLabel::find($request->id)))
                ? __('Das Label wurde aktualisiert')
                : __('Das Label konnte nicht aktualisiert werden');
        } elseif ((new EquipmentLabel)->add($request)) {
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
     *
     * @return bool
     */
    public function update(Request $request, EquipmentLabel $equipmentlabel)
    {
        $this->validateEquipmentLabel();
        $equipmentlabel->name = $request->name;
        $equipmentlabel->tld_string = $request->tld_string ?? env('APP_URL');
        $equipmentlabel->label = $request->label;
        $equipmentlabel->label_w = $request->label_w;
        $equipmentlabel->Label_h = $request->Label_h;
        $equipmentlabel->label_mt = $request->label_mt;
        $equipmentlabel->label_ml = $request->label_ml;
        $equipmentlabel->label_mr = $request->label_mr;
        $equipmentlabel->logo_svg = $request->logo_svg;
        $equipmentlabel->logo_h = $request->logo_h;
        $equipmentlabel->logo_w = $request->logo_w;
        $equipmentlabel->logo_x = $request->logo_x;
        $equipmentlabel->logo_y = $request->logo_y;
        $equipmentlabel->qrcode_y = $request->qrcode_y;
        $equipmentlabel->qrcode_x = $request->qrcode_x;
        $equipmentlabel->show_labels = isset($request->show_labels);
        $equipmentlabel->show_inventory = isset($request->show_inventory);
        $equipmentlabel->show_location = isset($request->show_location);

        return $equipmentlabel->save();
    }

    /**
     * Display the specified resource.
     *
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
     *
     * @return RedirectResponse
     */
    public function destroy(EquipmentLabel $equipmentlabel)
    {
        if ($equipmentlabel->delete()) {
            request()->session()->flash('status', __('Label erfolgreich gelöscht'));
        } else {
            request()->session()->flash('status', __('Label konnte leider nicht gelöscht werden :('));

        }

        return back();
    }

    public function validateEquipmentLabel(): array
    {
        return request()->validate([
            //            'eq_inventar_nr'     => [
            //                'bail',
            //                'max:100',
            //                'required',
            //                Rule::unique('equipment')->ignore(request('id'))
            //            ],

            'label' => 'required|max:20',
            'name' => 'max:100',
            'show_labels' => '',
            'show_inventory' => '',
            'show_location' => '',
            'tld_string' => '',
            'label_w' => '',
            'Label_h' => '',
            'label_ml' => '',
            'label_mt' => '',
            'label_mr' => '',
            'qrcode_y' => '',
            'qrcode_x' => '',
            'logo_y' => '',
            'logo_x' => '',
            'logo_h' => '',
            'logo_w' => '',
            'logo_svg' => '',
        ]);
    }
}
