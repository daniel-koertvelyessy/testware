<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentParam;
use App\Produkt;
use App\ProduktKategorieParam;
use App\ProduktParam;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class EquipmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('testware.equipment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return Application|Factory|Response|View
     */
    public function create(Request $request)
    {
        $produkt = (isset($request->produkt_id)) ? request('produkt_id') : false;
        return view('testware.equipment.create',['pk' => $request->pk, 'produkt'=>$produkt]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {



        $equipment = Equipment::create($this->validateNewEquipment());




        if (isset($request->pp_id)&& count($request->pp_id)>0) {


            for ($i=0; $i<count($request->pp_id);$i++)
            {
                $pp = ProduktParam::find($request->pp_id[$i]);
                $equipParam = new EquipmentParam();
                $equipParam->ep_label = $pp->pp_label;
                $equipParam->ep_name = $pp->ep_name;
                $equipParam->ep_value = $request->ep_value[$i];
                $equipParam->equipment_id = $equipment->id;
                $equipParam->save();
            }

        }

        $request->session()->flash('status', 'Das Gerät <strong>' . request('setNewEquipmentFromProdukt') . '</strong> wurde angelegt!');


        return redirect(route('equipment.show',['equipment'=>$equipment]));

    }

    /**
     * Display the specified resource.
     *
     * @param  Equipment $equipment
     * @return Application|Factory|Response|View
     */
    public function show(Equipment $equipment)
    {
        return view('testware.equipment.show',['equipment' => $equipment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Equipment $equipment
     * @return Response
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request   $request
     * @param  Equipment $equipment
     * @return Response
     */
    public function update(Request $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Equipment $equipment
     * @return Response
     */
    public function destroy(Equipment $equipment)
    {
        //
    }

    /**
     * @return array
     */
    public function validateNewEquipment(): array
    {
        return request()->validate([
            'eq_inventar_nr' => 'bail|unique:equipments,eq_inventar_nr|max:100|required',
            'eq_serien_nr' => 'max:100',
            'eq_qrcode' => '',
            'eq_text' => '',
            'eq_ibm' => 'date',
            'produkt_id' => '',
            'standort_id' => 'required',
            'equipment_state_id' => 'required'
        ]);
    }
}
