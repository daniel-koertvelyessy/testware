<?php

namespace App\Http\Controllers;

use App\AnforderungControlItem;
use App\ControlEquipment;
use App\ControlInterval;
use App\Equipment;
use App\EquipmentDoc;
use App\EquipmentFuntionControl;
use App\EquipmentHistory;
use App\EquipmentParam;
use App\EquipmentQualifiedUser;
use App\EquipmentUid;
use App\Produkt;
use App\ProduktAnforderung;
use App\ProduktKategorieParam;
use App\ProduktParam;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EquipmentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index() {
        return view('testware.equipment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return Application|Factory|Response|View
     */
    public function create(Request $request) {
        $produkt = (isset($request->produkt_id)) ? request('produkt_id') : false;
        return view('testware.equipment.create', ['pk' => $request->pk, 'produkt' => $produkt]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request) {
        $lastDate = $request->qe_control_date_last;

        $prod = Produkt::find($request->produkt_id);
        $equipment = Equipment::create($this->validateNewEquipment());

        $euid = new EquipmentUid();
        $euid->equipment_uid = $request->eq_uid;
        $euid->equipment_id = $equipment->id;
        $euid->save();

        $eh = new EquipmentHistory();
        $eh->eqh_eintrag_kurz = 'Gerät angelegt';
        $eh->eqh_eintrag_text = 'Das Gerät mit der Inventar-Nr' . request('eq_inventar_nr') . ' wurde angelegt';
        $eh->equipment_id = $equipment->id;
        $eh->save();

        foreach ($prod->ProduktAnforderung as $prodAnforderung) {
            $conEquip = new ControlEquipment();
            $interval = $prodAnforderung->Anforderung->an_control_interval;
            $conInt = $prodAnforderung->Anforderung->control_interval_id;
            $zeit = ControlInterval::find($conInt);
            $dueDate = date('Y-m-d', strtotime("+" . $interval . $zeit->ci_delta, strtotime($lastDate)));
            $conEquip->qe_control_date_last = $lastDate;
            $conEquip->qe_control_date_due = $dueDate;
            $conEquip->anforderung_id = $prodAnforderung->anforderung_id;
            $conEquip->equipment_id = $equipment->id;
            $conEquip->save();

            $eh = new EquipmentHistory();
            $eh->eqh_eintrag_kurz = 'Anforderung angelegt';
            $eh->eqh_eintrag_text = 'Für das Geräte wurde die Anforderung ' . $prodAnforderung->Anforderung->an_name_lang . ' angelegt, welche am ' . $dueDate . ' zum ersten Mal fällig wird.';
            $eh->equipment_id = $equipment->id;
            $eh->save();

        }

        if (isset($request->pp_id) && count($request->pp_id) > 0) {
            for ($i = 0; $i < count($request->pp_id); $i++) {
                $pp = ProduktParam::find($request->pp_id[$i]);
                $equipParam = new EquipmentParam();
                $equipParam->ep_label = $pp->pp_label;
                $equipParam->ep_name = $pp->ep_name;
                $equipParam->ep_value = $request->ep_value[$i];
                $equipParam->equipment_id = $equipment->id;
                $equipParam->save();
            }
        }

        $func = new EquipmentFuntionControl();
        $func->function_control_date = $request->function_control_date;
        $func->function_control_firma = ($request->function_control_firma === 'void') ? NULL : $request->function_control_firma;
        $func->function_control_profil = ($request->function_control_profil === 'void') ? NULL : $request->function_control_profil;
        $func->function_control_pass = $request->function_control_pass;
        $func->equipment_id = $equipment->id;
        $func->save();

        $eh = new EquipmentHistory();
        $eh->eqh_eintrag_kurz = 'Funktionsprüfung erfolgt';
        $eh->eqh_eintrag_text = 'Das Geräte wurde am ' . $request->function_control_date . ' einer Funktionsprüfung unterzogen.';
        $eh->eqh_eintrag_text .= ($request->function_control_pass === '1') ? ' Die Prüfung wurde erfolgreich abgeschlossen.' : ' Die Prüfung konnte nicht erfolgreich abgeschlossen werden. ';
        if ($request->function_control_text !== NULL)
            $eh->eqh_eintrag_text .= 'Bemerkungen: ' . $request->function_control_text;
        $eh->equipment_id = $equipment->id;
        $eh->save();

        if ($request->hasFile('equipDokumentFile')) {
            $proDocFile = new EquipmentDoc();
            $file = $request->file('equipDokumentFile');
            $validation = $request->validate([
                'equipDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:10240', // size:2048 => 2048kB
                'eqdoc_name_kurz'   => 'required|max:150'
            ]);
            $proDocFile->eqdoc_name_lang = $file->getClientOriginalName();
            $proDocFile->eqdoc_name_pfad = $file->store('equipment_docu/' . $equipment->id);
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->equipment_id = $equipment->id;
            $proDocFile->eqdoc_name_text = request('eqdoc_name_text');
            $proDocFile->eqdoc_name_kurz = request('eqdoc_name_kurz');
            $proDocFile->save();
        }

        if ($request->function_control_profil !=='void'){
            $qualifiedUser = new EquipmentQualifiedUser();
            $qualifiedUser->equipment_qualified_firma = NULL;
            $qualifiedUser->equipment_qualified_date = date('Y-m-d');
            $qualifiedUser->user_id = $request->function_control_profil;
            $qualifiedUser->equipment_id = $equipment->id;
            $qualifiedUser->save();

            $eh = new EquipmentHistory();
            $eh->eqh_eintrag_kurz = 'Befähigte Person angelegt';
            $eh->eqh_eintrag_text = User::find($request->function_control_profil)->name . ' wurde als befähigte Person hinzugefügt.';
            $eh->equipment_id = $equipment->id;
            $eh->save();
        }

        $request->session()->flash('status', 'Das Gerät <strong>' . request('setNewEquipmentFromProdukt') . '</strong> wurde angelegt!');

        return redirect(route('equipment.show', ['equipment' => $equipment]));

    }

    /**
     * @return array
     */
    public function validateNewEquipment()
    : array {
        return request()->validate([
            'eq_inventar_nr'     => 'bail|unique:equipment,eq_inventar_nr|max:100|required',
            'eq_serien_nr'       => 'bail|unique:equipment,eq_serien_nr|max:100',
            'eq_uid'             => 'bail|required|unique:equipment,eq_uid',
            'eq_qrcode'          => '',
            'eq_text'            => '',
            'eq_ibm'             => 'date',
            'produkt_id'         => '',
            'standort_id'        => 'required',
            'equipment_state_id' => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Equipment $equipment
     * @return Application|Factory|Response|View
     */
    public function show(Equipment $equipment) {
        return view('testware.equipment.show', ['equipment' => $equipment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Equipment $equipment
     * @return Application|Factory|Response|View
     */
    public function edit(Equipment $equipment) {
        return view('testware.equipment.edit', ['equipment' => $equipment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request   $request
     * @param  Equipment $equipment
     * @return Application|Factory|RedirectResponse|View
     */
    public function update(Request $request, Equipment $equipment) {

        $feld = '';
        $flag = false;
        $upd = Equipment::find($request->id);


        if (!isset($request->setFieldReadWrite) && $upd->eq_inventar_nr === $request->eq_inventar_nr) {
            $equipment->update($this->validateEquipment());
        } else if (isset($request->setFieldReadWrite) && $upd->eq_inventar_nr === $request->eq_inventar_nr) {
            $equipment->update($this->validateEquipment());
        } else {
            $equipment->update($this->validateNewEquipment());
        }

        $feld .= __(':user führte folgende Änderungen durch', ['user' => Auth::user()->username]) . ' => ';
        if ($upd->eq_serien_nr != $request->eq_serien_nr) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Seriennummer'),
                    'old' => $upd->eq_serien_nr,
                    'new' => $request->eq_serien_nr,
                ]) . ' | ';
            $flag = true;
        }
        if ($upd->eq_qrcode != $request->eq_qrcode) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('QR Code'),
                    'old' => $upd->eq_qrcode,
                    'new' => $request->eq_qrcode,
                ]) . ' | ';
            $flag = true;
        }
        if ($upd->eq_ibm != $request->eq_ibm) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Inbetriebnahme am'),
                    'old' => $upd->eq_ibm,
                    'new' => $request->eq_ibm,
                ]) . ' | ';
            $flag = true;
        }
        if ($upd->eq_text != $request->eq_text) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Beschreibung'),
                    'old' => $upd->eq_text,
                    'new' => $request->eq_text,
                ]) . ' | ';
            $flag = true;
        }
        if ($upd->equipment_state_id != $request->equipment_state_id) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Geräte Status'),
                    'old' => $upd->equipment_state_id,
                    'new' => $request->equipment_state_id,
                ]) . ' | ';
            $flag = true;
        }
        if ($upd->standort_id != $request->standort_id) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Aufstellplatz / Standort'),
                    'old' => $upd->standort_id,
                    'new' => $request->standort_id,
                ]) . ' | ';
            $flag = true;
        }
        if ($upd->produkt_id != $request->produkt_id) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Produkt'),
                    'old' => $upd->produkt_id,
                    'new' => $request->produkt_id,
                ]) . ' | ';
            $flag = true;
        }

        if ($flag) {

            $eh = new EquipmentHistory();

            $eh->eqh_eintrag_kurz = __('Gerät geändert');
            $eh->eqh_eintrag_text = $feld;
            $eh->equipment_id = $equipment->id;
            $eh->save();
            $request->session()->flash('status', __('Das Gerät <strong>:equipName</strong> wurde aktualisiert!', ['equipName' => request('eq_inventar_nr')]));

            return view('testware.equipment.show', ['equipment' => $equipment]);
        } else {
            $request->session()->flash('status', __('Es wurden keine Änderungen festgestellt.'));
            return view('testware.equipment.show', ['equipment' => $equipment]);
        }
    }

    /**
     * @return array
     */
    public function validateEquipment()
    : array {
        return request()->validate([
            'eq_inventar_nr'     => '',
            'eq_serien_nr'       => 'max:100',
            'eq_qrcode'          => '',
            'eq_text'            => '',
            'eq_ibm'             => 'date',
            'produkt_id'         => '',
            'standort_id'        => 'required',
            'equipment_state_id' => 'required'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Equipment $equipment
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Equipment $equipment) {


        foreach (EquipmentDoc::where('equipment_id', $equipment->id)->get() as $prodDoku) {
            EquipmentDoc::find($prodDoku->id);
            $file = $prodDoku->proddoc_name_lang;
            Storage::delete($prodDoku->proddoc_name_pfad);
            $prodDoku->delete();

        }

        $equipment->delete();

        return redirect()->route('equipMain');

    }

    public function getEquipmentAjaxListe(Request $request) {
        return DB::table('equipment')->select(
            'eq_inventar_nr',
            'equipment.id',
            'equipment.eq_serien_nr',
            'prod_name_lang'
        )
            ->join('produkts', 'produkts.id', '=', 'equipment.produkt_id')
            ->where('eq_serien_nr', 'like', '%' . $request->term . '%')
            ->orWhere('eq_inventar_nr', 'like', '%' . $request->term . '%')
            ->orWhere('eq_uid', 'like', '%' . $request->term . '%')
            ->orWhere('prod_nummer', 'like', '%' . $request->term . '%')
            ->orWhere('prod_name_lang', 'like', '%' . $request->term . '%')
            ->orWhere('prod_name_kurz', 'like', '%' . $request->term . '%')
            ->orWhere('prod_name_text', 'like', '%' . $request->term . '%')
            ->get();
    }
}
