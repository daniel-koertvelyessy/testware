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
use App\EquipmentWarranty;
use App\Produkt;
use App\ProduktAnforderung;
use App\ProduktKategorieParam;
use App\ProduktParam;
use App\Stellplatz;
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
     *
     * @return Application|Factory|Response|View
     */
    public function create(Request $request)
    {
        $produkt = (isset($request->produkt_id)) ? request('produkt_id') : false;
        return view('testware.equipment.create', [
            'pk'      => $request->pk,
            'produkt' => $produkt
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'eq_inventar_nr'     => 'bail|unique:equipment,eq_inventar_nr|max:100|required',
            'eq_serien_nr'       => 'bail|nullable|unique:equipment,eq_serien_nr|max:100',
            'eq_uid'             => 'bail|required|unique:equipment,eq_uid',
            'eq_name'            => '',
            'eq_qrcode'          => '',
            'eq_text'            => '',
            'eq_price'           => '',
            'installed_at'       => 'date',
            'purchased_at'       => 'date',
            'produkt_id'         => '',
            'storage_id'         => 'required',
            'equipment_state_id' => 'required'
        ]);
        $equipment = new Equipment();
        $equipment->eq_inventar_nr = $request->eq_inventar_nr;
        $equipment->eq_serien_nr = $request->eq_serien_nr;
        $equipment->eq_name = $request->eq_name;
        $equipment->eq_uid = $request->eq_uid;
        $equipment->eq_qrcode = $request->eq_qrcode;
        $equipment->eq_text = $request->eq_text;
        $equipment->eq_price = $request->eq_price;
        $equipment->installed_at = $request->installed_at;
        $equipment->purchased_at = $request->purchased_at;
        $equipment->produkt_id = $request->produkt_id;
        $equipment->storage_id = $request->storage_id;
        /**
         * Check if equipment function check is passed and if a report has been submitted
         */
        $equipment_state_id = ($request->function_control_pass === '0') ? 4 : 1;
        if (!$request->hasFile('equipDokumentFile')) $equipment_state_id = 4;
        $equipment->equipment_state_id = $equipment_state_id;

        $equipment->save();


        $lastDate = $request->qe_control_date_last;


        $euid = new EquipmentUid();
        $euid->equipment_uid = $request->eq_uid;
        $euid->equipment_id = $equipment->id;
        $euid->save();

        $eh = new EquipmentHistory();
        $eh->eqh_eintrag_kurz = __('Gerät angelegt');
        $eh->eqh_eintrag_text = __('Das Gerät mit der Inventar-Nr :invno wurde angelegt', ['invno' => request('eq_inventar_nr')]);
        $eh->equipment_id = $equipment->id;
        $eh->save();

        if (isset($request->warranty_expires_at)) {
            $request->validate([
                'warranty_expires_at' => 'date|date_format:Y-m-d'
            ]);
            $eq_warranty = new EquipmentWarranty();
            $eq_warranty->expires_at = $request->warranty_expires_at;
            $eq_warranty->equipment_id = $equipment->id;
            $eq_warranty->save();
        }

        foreach (Produkt::find($request->produkt_id)->ProduktAnforderung as $prodAnforderung) {
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
            $eh->eqh_eintrag_kurz = __('Anforderung angelegt');
            $eh->eqh_eintrag_text = __('Für das Geräte wurde die Anforderung :anname angelegt, welche am :duedate zum ersten Mal fällig wird.', [
                'anname'  => $prodAnforderung->Anforderung->an_name,
                'duedate' => $dueDate
            ]);
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

        (new EquipmentFuntionControl())->addControlEvent($request, $equipment->id);

        if ($request->hasFile('equipDokumentFile')) {
            $proDocFile = new EquipmentDoc();
            $file = $request->file('equipDokumentFile');
            $validation = $request->validate([
                'equipDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:10240',
                // size:2048 => 2048kB
                'eqdoc_label'       => 'required|max:150'
            ]);
            $proDocFile->eqdoc_name = $file->getClientOriginalName();
            $proDocFile->eqdoc_name_pfad = $file->store('equipment_docu/' . $equipment->id);
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->equipment_id = $equipment->id;
            $proDocFile->eqdoc_description = request('eqdoc_description');
            $proDocFile->eqdoc_label = request('eqdoc_label');
            $proDocFile->save();
        } else {
            $eh = new EquipmentHistory();
            $eh->eqh_eintrag_kurz = __('Fehlende Angaben beim Anlegen');
            $eh->eqh_eintrag_text = __('Das Geräte wurde ohne Prüfdokumente angelegt. Gerät erhält den Status "gesperrt"!');
            $eh->equipment_id = $equipment->id;
            $eh->save();
        }

        if ($request->function_control_profil !== 'void') {
            $qualifiedUser = new EquipmentQualifiedUser();
            $qualifiedUser->equipment_qualified_firma = null;
            $qualifiedUser->equipment_qualified_date = date('Y-m-d');
            $qualifiedUser->user_id = $request->function_control_profil;
            $qualifiedUser->equipment_id = $equipment->id;
            $qualifiedUser->save();

            $eh = new EquipmentHistory();
            $eh->eqh_eintrag_kurz = __('Befähigte Person angelegt');
            $eh->eqh_eintrag_text = User::find($request->function_control_profil)->name . __(' wurde als befähigte Person hinzugefügt.');
            $eh->equipment_id = $equipment->id;
            $eh->save();
        }

        $request->session()->flash('status', __('Das Gerät <strong>:eqname</strong> wurde angelegt!', ['eqname' => request('eq_name')]));

        return redirect(route('equipment.show', ['equipment' => $equipment]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Equipment $equipment
     *
     * @return Application|Factory|Response|View
     */
    public function show(Equipment $equipment)
    {
        return view('testware.equipment.show', ['equipment' => $equipment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Equipment $equipment
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Equipment $equipment)
    {
        return view('testware.equipment.edit', ['equipment' => $equipment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request   $request
     * @param  Equipment $equipment
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function update(Request $request, Equipment $equipment)
    {

        $feld = '';
        $flag = false;
        $oldEquipment = Equipment::find($request->id);

        if (!isset($request->setFieldReadWrite) && $oldEquipment->eq_inventar_nr === $request->eq_inventar_nr) {
            $equipment->update($this->validateEquipment());
        } elseif (isset($request->setFieldReadWrite) && $oldEquipment->eq_inventar_nr === $request->eq_inventar_nr) {
            $equipment->update($this->validateEquipment());
        } else {
            $equipment->update($this->validateNewEquipment());
        }

        $feld .= __(':user führte folgende Änderungen durch', ['user' => Auth::user()->username]) . ' => ';
        if ($oldEquipment->eq_serien_nr != $request->eq_serien_nr) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Seriennummer'),
                    'old' => $oldEquipment->eq_serien_nr,
                    'new' => $request->eq_serien_nr,
                ]) . ' | ';
            $flag = true;
        }
        if ($oldEquipment->eq_qrcode != $request->eq_qrcode) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('QR Code'),
                    'old' => $oldEquipment->eq_qrcode,
                    'new' => $request->eq_qrcode,
                ]) . ' | ';
            $flag = true;
        }

        if ($oldEquipment->purchased_at != $request->purchased_at) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Kaufdatum'),
                    'old' => $oldEquipment->purchased_at,
                    'new' => $request->purchased_at,
                ]) . ' | ';
            $flag = true;
        }

        if ($oldEquipment->installed_at != $request->installed_at) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Inbetriebnahme am'),
                    'old' => $oldEquipment->installed_at,
                    'new' => $request->installed_at,
                ]) . ' | ';
            $flag = true;
        }
        if ($oldEquipment->eq_text != $request->eq_text) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Beschreibung'),
                    'old' => $oldEquipment->eq_text,
                    'new' => $request->eq_text,
                ]) . ' | ';
            $flag = true;
        }
        if ($oldEquipment->equipment_state_id != $request->equipment_state_id) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Geräte Status'),
                    'old' => $oldEquipment->equipment_state_id,
                    'new' => $request->equipment_state_id,
                ]) . ' | ';
            $flag = true;
        }
        if ($oldEquipment->storage_id != $request->storage_id) {
            $feld .= __('Feld :fld von [:old] in [:new] geändert', [
                    'fld' => __('Aufstellplatz / Standort'),
                    'old' => $oldEquipment->storage->storage_label,
                    'new' => \App\Storage::find($request->storage_id)->storage_label,
                ]) . ' | ';
            $flag = true;
        }
        if ($oldEquipment->produkt_id != $request->produkt_id) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Produkt'),
                    'old' => $oldEquipment->produkt_id,
                    'new' => $request->produkt_id,
                ]) . ' | ';
            $flag = true;
        }

        if ($oldEquipment->eq_price != $request->eq_price) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Kaufpreis'),
                    'old' => $oldEquipment->eq_price,
                    'new' => $request->eq_price,
                ]) . ' | ';
            $flag = true;
        }

        if ($oldEquipment->eq_price != $request->eq_price) {
            $feld .= __('Feld :fld von :old in :new geändert', [
                    'fld' => __('Kaufpreis'),
                    'old' => $oldEquipment->eq_price,
                    'new' => $request->eq_price,
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
    : array
    {
        return request()->validate([
            'eq_inventar_nr'     => '',
            'eq_serien_nr'       => 'max:100',
            'eq_qrcode'          => '',
            'eq_text'            => '',
            'installed_at'       => 'date',
            'purchased_at'       => 'date',
            'eq_price'           => '',
            'produkt_id'         => '',
            'storage_id'         => 'required',
            'equipment_state_id' => 'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateNewEquipment()
    : array
    {
        return request()->validate([
            'eq_inventar_nr'     => 'bail|unique:equipment,eq_inventar_nr|max:100|required',
            'eq_serien_nr'       => 'bail|nullable|unique:equipment,eq_serien_nr|max:100',
            'eq_uid'             => 'bail|required|unique:equipment,eq_uid',
            'eq_qrcode'          => '',
            'eq_text'            => '',
            'eq_price'           => '',
            'installed_at'       => 'date',
            'purchased_at'       => 'date',
            'produkt_id'         => '',
            'storage_id'         => 'required',
            'equipment_state_id' => 'required'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Equipment $equipment
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Equipment $equipment)
    {


        foreach (EquipmentDoc::where('equipment_id', $equipment->id)->get() as $prodDoku) {
            EquipmentDoc::find($prodDoku->id);
            $file = $prodDoku->proddoc_name;
            Storage::delete($prodDoku->proddoc_name_pfad);
            $prodDoku->delete();
        }

        $equipment->delete();

        return redirect()->route('equipMain');
    }

    public function getEquipmentAjaxListe(Request $request)
    {
        return DB::table('equipment')->select('eq_inventar_nr', 'equipment.id', 'equipment.eq_serien_nr', 'prod_name')->join('produkts', 'produkts.id', '=', 'equipment.produkt_id')->where('eq_serien_nr', 'like', '%' . $request->term . '%')->orWhere('eq_inventar_nr', 'like', '%' . $request->term . '%')->orWhere('eq_uid', 'like', '%' . $request->term . '%')->orWhere('prod_nummer', 'like', '%' . $request->term . '%')->orWhere('prod_name', 'like', '%' . $request->term . '%')->orWhere('prod_label', 'like', '%' . $request->term . '%')->orWhere('prod_description', 'like', '%' . $request->term . '%')->get();
    }
}
