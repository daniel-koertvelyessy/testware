<?php

namespace App\Http\Controllers;

use App\AnforderungControlItem;
use App\ControlEquipment;
use App\ControlInterval;
use App\Equipment;
use App\EquipmentHistory;
use App\EquipmentParam;
use App\Produkt;
use App\ProduktAnforderung;
use App\ProduktKategorieParam;
use App\ProduktParam;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    use SoftDeletes;

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



        $lastDate = $request->qe_control_date_last;

        $prod = Produkt::find($request->produkt_id);
        $equipment = Equipment::create($this->validateNewEquipment());
        $eh = new EquipmentHistory();

        $eh->eqh_eintrag_kurz = 'Gerät angelegt';
        $eh->eqh_eintrag_text = 'Das Gerät mit der Inventar-Nr'.request('eq_inventar_nr').' wurde angelegt';
        $eh->equipment_id = $equipment->id;
        $eh->save();

        foreach($prod->ProduktAnforderung as $prodAnforderung)
        {

            foreach (AnforderungControlItem::where('anforderung_id',$prodAnforderung->anforderung_id)->get()  as $aci ){
                $conEquip = new ControlEquipment();
                $interval = $prodAnforderung->Anforderung->an_control_interval;
                $conInt = $prodAnforderung->Anforderung->control_interval_id;
                $zeit = ControlInterval::find($conInt);

                $dueDate = date('Y-m-d', strtotime("+".$interval. $zeit->ci_delta, strtotime($lastDate)));

                $conEquip->qe_control_date_last = $lastDate;
                $conEquip->qe_control_date_due = $dueDate;
                $conEquip->anforderung_control_item_id = $aci->id;
            $conEquip->equipment_id = $equipment->id ;
                $conEquip->save();

                $eh = new EquipmentHistory();

                $eh->eqh_eintrag_kurz = 'Vorgang angelegt';
                $eh->eqh_eintrag_text = 'Für das Geräte wurde ein Vorgang '.$aci->aci_name_kurz.' angelegt, der am '.$dueDate.' zum ersten Mal füllig wird.';
                $eh->equipment_id = $equipment->id;
                $eh->save();

            }




        }

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
            'eq_inventar_nr' => 'bail|unique:equipment,eq_inventar_nr|max:100|required',
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
