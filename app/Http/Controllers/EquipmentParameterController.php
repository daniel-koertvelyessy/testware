<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentParam;
use App\Http\Resources\products\ProductParam;
use App\ProduktParam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class EquipmentParameterController extends Controller
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


    public function store(Request $request):RedirectResponse
    {
        $this->validateEquipmentParam();
        $msg = '';
        $equipment = Equipment::find($request->equipment_id);

        if($equipment) {
           $msg .= (new EquipmentParam)->addParam(
                $request->ep_label,
                $request->ep_name,
                $request->ep_value,
                $request->equipment_id
            )
               ? __('Parameter erfolgreich angelegt.')
               : __('Fehler beim Anlegen');

            if (isset($request->addParameterToProduct)) {
                /**
                 * Add to parent Product
                 */
                $msg .=  (new ProduktParam)->addParam(
                    $request->ep_label,
                    $request->ep_name,
                    $request->ep_value,
                    $equipment->produkt->id
                )
                    ? __('Parameter erfolgreich dem Produkt angefügt.')
                    : __('Fehler beim Anlegen des Produktparameters');

            }

            if (isset($request->addParameterToProduct) && isset($request->polulateToAllEquipment)) {
                /**
                 * Add to all related equipment instances
                 */
                $k=0;
                foreach(Equipment::where('produkt_id',$equipment->produkt_id)->get() as $instance){
                    if ($instance->eq_uid != $equipment->eq_uid) {
                        if ((new EquipmentParam)->addParam(
                            $request->ep_label,
                            $request->ep_name,
                            $request->ep_value,
                            $instance->id
                        )) {
                            $k++;
                        }
                    }
                }

                $msg .= __('Der Parameter wurde an :num Geräte angefügt.',['num'=>$k]);


            }
        } else {
            $msg = __('Das referenzierte Geräte wurde nicht gefunden!');
        }

        $request->session()->flash('status',
                                    $msg);
        return back();


    }

    public function validateEquipmentParam(): array
    {
        return request()->validate([
                                       'ep_label' => [
                                           'bail',
                                           'max:20',
                                           'required',
                                           Rule::unique('equipment_params')->ignore(request('id'))
                                       ],
                                       'ep_name' => 'required|max:150',
                                       'ep_value' => 'required|max:150',
                                       'equipment_id' => 'required',
                                   ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
