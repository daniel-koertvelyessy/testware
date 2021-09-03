<?php

namespace App\Http\Controllers;

use App\ControlEquipment;
use App\Equipment;
use App\EquipmentDoc;
use App\EquipmentFuntionControl;
use App\EquipmentHistory;
use App\EquipmentInstruction;
use App\EquipmentParam;
use App\EquipmentQualifiedUser;
use App\EquipmentUid;
use App\EquipmentWarranty;
use App\ProductInstructedUser;
use App\ProductQualifiedUser;
use App\Produkt;
use App\ProduktDoc;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
            'eq_inventar_nr'     => [
                'bail',
                'max:100',
                'required',
                Rule::unique('equipment')->ignore($request->id)
            ],
            'eq_serien_nr'       => [
                'bail',
                'nullable',
                'max:100',
                Rule::unique('equipment')->ignore($request->id)
            ],
            'eq_uid'             => [
                'bail',
                'required',
                Rule::unique('equipment')->ignore($request->id)
            ],
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

        (new EquipmentUid)->addNew($request->eq_uid, $equipment->id);

        (new EquipmentHistory)->add(__('Gerät angelegt'), __('Das Gerät mit der Inventar-Nr :invno wurde angelegt', ['invno' => request('eq_inventar_nr')]), $equipment->id);

        if (isset($request->warranty_expires_at)) {
            $request->validate(['warranty_expires_at' => 'after:today|date_format:Y-m-d']);
            (new EquipmentWarranty)->addEquipment($request->warranty_expires_at, $equipment->id);
        }

        foreach (Produkt::find($request->produkt_id)->ProduktAnforderung as $prodAnforderung) {

            $dueDate = (new ControlEquipment)->addEquipment($prodAnforderung, $equipment->id, $request->qe_control_date_last);

            (new EquipmentHistory)->add(__('Anforderung angelegt'), __('Für das Geräte wurde die Anforderung :anname angelegt, welche am :duedate zum ersten Mal fällig wird.', [
                'anname'  => $prodAnforderung->Anforderung->an_name,
                'duedate' => $dueDate
            ]), $equipment->id);

        }

        foreach (ProductQualifiedUser::where('produkt_id', $request->produkt_id)->get() as $productQualifiedUser) {
            (new EquipmentQualifiedUser)->addEquipment($productQualifiedUser, $equipment->id);
        }

        foreach (ProductInstructedUser::where('produkt_id', $request->produkt_id)->get() as $productInstructedUser) {
            (new EquipmentInstruction)->addEquipment($productInstructedUser, $equipment->id);
        }

        if (isset($request->pp_id) && count($request->pp_id) > 0) {
            for ($i = 0; $i < count($request->pp_id); $i++) (new EquipmentParam)->addEquipmnt($request->pp_id[$i], $request->ep_value[$i], $equipment->id);
        }

        (new EquipmentFuntionControl())->addControlEvent($request, $equipment->id);

        if ($request->hasFile('equipDokumentFile')) {
            $proDocFile = new EquipmentDoc();
            $file = $request->file('equipDokumentFile');
            $validation = $request->validate([
                'equipDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:20480',
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
            (new EquipmentHistory)->add(__('Fehlende Angaben beim Anlegen'), __('Das Geräte wurde ohne Prüfdokumente angelegt. Gerät erhält den Status "gesperrt"!'), $equipment->id);
        }

        if ($request->function_control_profil !== 'void') {

            $qualifiedUser = new EquipmentQualifiedUser();
            $qualifiedUser->equipment_qualified_firma = null;
            $qualifiedUser->equipment_qualified_date = date('Y-m-d');
            $qualifiedUser->user_id = $request->function_control_profil;
            $qualifiedUser->equipment_id = $equipment->id;
            $qualifiedUser->save();

            (new EquipmentHistory)->add(__('Befähigte Person angelegt'), User::find($request->function_control_profil)->name . ' ' . __('wurde als befähigte Person hinzugefügt.'), $equipment->id);

        }

        $request->session()->flash('status', __('Das Gerät <strong>:eqname</strong> wurde angelegt!', ['eqname' => request('eq_name')]));

        return redirect(route('equipment.show', compact('equipment')));
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
        foreach(EquipmentDoc::where('equipment_id',$equipment->id)->where('document_type_id',2)->get() as $equipmentDocFile){
            if(Storage::disk('local')->missing($equipmentDocFile->eqdoc_name_pfad)){
                Log::warning('Dateireferenz für Funktionsprüfung ('. $equipmentDocFile->eqdoc_name_pfad .') aus DB EquipmentDoc existiert nicht auf dem Laufwerk. Datensatz wird gelöscht!');
//                dump('delete '. $equipmentDocFile->eqdoc_name_pfad);
            $equipmentDocFile->delete();
            }

        }

        foreach(ProduktDoc::where('produkt_id',$equipment->Produkt->id)->where('document_type_id',1)->get() as $productDocFile){
            if(Storage::disk('local')->missing($productDocFile->proddoc_name_pfad)){
                Log::warning('Dateireferenz ('. $productDocFile->proddoc_name_pfad .') aus DB EquipmentDoc existiert nicht auf dem Laufwerk. Datensatz wird gelöscht!');
//                dump('delete '. $productDocFile->eqdoc_name_pfad);
            $productDocFile->delete();
            }

        }


        return view('testware.equipment.show', compact('equipment'));
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
        return view('testware.equipment.edit', compact('equipment'));
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
            $equipment->update($this->validateEquipment());
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
            (new EquipmentHistory)->add(__('Gerät geändert'), $feld, $equipment->id);
            $request->session()->flash('status', __('Das Gerät <strong>:equipName</strong> wurde aktualisiert!', ['equipName' => request('eq_inventar_nr')]));

            return view('testware.equipment.show', compact('equipment'));
        } else {
            $request->session()->flash('status', __('Es wurden keine Änderungen festgestellt.'));
            return view('testware.equipment.show', compact('equipment'));
        }
    }


    /**
     * @return array
     */
    public function validateEquipment()
    : array
    {
        return request()->validate([
            'eq_inventar_nr'     => [
                'bail',
                'max:100',
                'required',
                Rule::unique('equipment')->ignore(request('id'))
            ],
            'eq_serien_nr'       => [
                'bail',
                'nullable',
                'max:100',
                Rule::unique('equipment')->ignore(request('id'))
            ],
            'eq_uid'             => [
                'bail',
                'required',
                Rule::unique('equipment')->ignore(request('id'))
            ],
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
