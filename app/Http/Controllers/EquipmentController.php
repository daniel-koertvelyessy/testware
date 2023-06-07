<?php

namespace App\Http\Controllers;

use App\Anforderung;
use App\Equipment;
use App\EquipmentDoc;
use App\EquipmentHistory;
use App\EquipmentInstruction;
use App\EquipmentParam;
use App\EquipmentQualifiedUser;
use App\EquipmentState;
use App\EquipmentUid;
use App\EquipmentWarranty;
use App\FirmaProdukt;
use App\Http\Actions\Equipment\EquipmentAction;
use App\Http\Services\Equipment\EquipmentDocumentService;
use App\Http\Services\Equipment\EquipmentEventService;
use App\Http\Services\Equipment\EquipmentService;
use App\ProductInstructedUser;
use App\ProductQualifiedUser;
use App\Produkt;
use App\ProduktAnforderung;
use App\Storage;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Str;

class EquipmentController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('testware.equipment.index',
            [
                'equipmentlist' => Equipment::all()->sortable()->paginate(10),
                'header' => __('Übersicht Geräte')
            ]);
    }

    public function controlequipment()
    {
        $service = new EquipmentEventService();
        return view('testware.equipment.index',
            [
                'equipmentlist' => $service->makeEquipmentControlCollection(),
                'header' => __('Übersicht Prüfgeräte')
            ]);
    }

    public function statuslist(EquipmentState $equipmentState)
    {

        return view('testware.equipment.state_list',
            [
                'equipmentList' => Equipment::where('equipment_state_id',
                    $equipmentState->id)->get(),
                'status_label' => $equipmentState->estat_label
            ]);

    }


    public function create(Request $request)
    {

        $companyList = FirmaProdukt::where('produkt_id',
            $request->produkt_id)->get();
        return view('testware.equipment.create',
            [
                'pk' => $request->pk,
                'produkt' => Produkt::find(request('produkt_id')),
                'companies' => $companyList
            ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $service = new EquipmentService();

        $service->vaidateEquipmnt($request);

        if (isset($request->warranty_expires_at)) {
            $request->validate([
                'installed_at' => 'date',
                'warranty_expires_at' => 'after:installed_at|date_format:Y-m-d',
            ]);
        }

        if (isset($request->setRequirementToProduct)) {
            (new ProduktController)->addProduktAnforderung($request);
        }

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
        $equipment_state_id = ($request->function_control_pass === '0')
            ? 4
            : 1;
        if (!$request->hasFile('equipDokumentFile')) {
            $equipment_state_id = 4;
        }
        $equipment->equipment_state_id = $equipment_state_id;

        $equipment->save();

        (new EquipmentUid)->addNew($request->eq_uid,
            $equipment->id);

        (new EquipmentHistory)->add(__('Gerät angelegt'),
            __('Das Gerät mit der Inventar-Nr :invno wurde angelegt',
                ['invno' => request('eq_inventar_nr')]),
            $equipment->id);

        if (isset($request->warranty_expires_at)) {
            (new EquipmentWarranty)->addEquipment($request->warranty_expires_at,
                $equipment->id);
        }


        $service->transferProductQualifiedUser($request,
            $equipment);

        $service->transferProductInstructedUser($request,
            $equipment);

        $service->transferProductParameters($request,
            $equipment);


        $request->session()->flash('status',
            __('Das Gerät <strong>:eqname</strong> wurde angelegt!',
                ['eqname' => request('eq_name')]));


        return redirect()->route('control.manual',
            [
                'equipment' => $equipment,
                'requirement' => Anforderung::find($request->anforderung_id)
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Equipment  $equipment
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(Equipment $equipment)
    {

        $serviceDocument = new EquipmentDocumentService();

        $service = new EquipmentService();

        EquipmentAction::deleteLoseEquipmentDocumentEntries($equipment);

        EquipmentAction::deleteLoseProductDocumentEntries($equipment);

        EquipmentAction::deleteLoseRequirementEntries($equipment);

        if (Storage::find($equipment->storage_id)) {
            $value = Storage::find($equipment->storage_id)->getStoragePath();
        } else {
            $value = __('nicht zugeordnet');
        }
        return view('testware.equipment.show',
            [
                'loggedInUserIsQualified' => $service->checkUserQualified($equipment),
                'upcomingControlList' => $service->getUpcomingControlItems($equipment),
                'onetimeControlList' => $service->getOntimeControlItems($equipment),
                'instructedPersonList' => $service->getInstruectedPersonList($equipment),
                'requirementList' => $service->getRequirementList($equipment),
                'recentControlList' => $service->getRecentExecutedControls($equipment),
                'euqipmentDocumentList' => $serviceDocument->getDocumentList($equipment),
                'functionDocumentList' => $serviceDocument->getFunctionTestDocumentList($equipment),
                'newFileList' => $serviceDocument->checkStorageSyncDB($equipment),
                'companyString' => $service->makeCompanyString($equipment),
                'equipment' => $equipment,
                'parameterListItems' => $service->getParamList($equipment),
                'locationpath' => $value
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Equipment  $equipment
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Equipment $equipment)
    {
        return view('testware.equipment.edit',
            compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Equipment  $equipment
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function update(Request $request, Equipment $equipment)
    {

        $changedItems = (new EquipmentService)->checkUpdatedFields($request,
            Equipment::find($request->id));

        if ($changedItems['changedStatus'] || count($changedItems['changedPrameter']) > 0) {
            $equipment->update($this->validateEquipment());
            (new EquipmentHistory)->add(__('Gerät geändert'),
                $changedItems['changedItems'],
                $equipment->id);
            $msg = __('Das Gerät <strong>:equipName</strong> wurde aktualisiert!',
                ['equipName' => request('eq_inventar_nr')]);
        } else {
            $msg = __('Es wurden keine Änderungen festgestellt.');
        }

        $request->session()->flash('status',
            $msg);
        return redirect()->route('equipment.show',
            $equipment);
    }


    /**
     * @return array
     */
    public function validateEquipment(): array
    {
        return request()->validate([
            'eq_inventar_nr' => [
                'bail',
                'max:250',
                'required',
                Rule::unique('equipment')->ignore(request('id'))
            ],
            'eq_serien_nr' => [
                'bail',
                'nullable',
                'max:250',
                Rule::unique('equipment')->ignore(request('id'))
            ],
            'eq_uid' => [
                'bail',
                'required',
                Rule::unique('equipment')->ignore(request('id'))
            ],
            'eq_name' => '',
            'eq_qrcode' => '',
            'eq_text' => '',
            'eq_price' => 'nullable|numeric',
            'installed_at' => 'date',
            'purchased_at' => 'date',
            'produkt_id' => '',
            'storage_id' => 'required',
            'equipment_state_id' => 'required'
        ],
            [
                'eq_inventar_nr.required' => __('Ein Geräte mit dieser Inventarnummer existiert bereits!'),
                'eq_serien_nr.required' => __('Ein Gerät mit dieser Seriennummer existiert bereits!'),
                //               'eq_price.numberic' => __('Ein Gerät mit dieser Seirennummer existiert bereits!'),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Equipment  $equipment
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {

        /**
         * Delete all related objects first
         */
        $objects = EquipmentAction::deleteRelatedObjetcs($equipment);

        /**
         *
         * Since the deletion of the equipment will set the deleted_at field with a timestamp
         * rather than deleting the database entry itself, the serial number and invertory id
         * recieve a postfix to prevent the unique violation of the fields.
         *
         */
        $equipment->eq_serien_nr = substr($equipment->eq_serien_nr.'|'.Str::uuid(),
            0,
            250);
        $equipment->eq_inventar_nr = substr($equipment->eq_inventar_nr.'|'.Str::uuid(),
            0,
            250);
        $equipment->save();


        if ($equipment->delete()) {
            $msg = __('Geräte wurde mit
                 :eCon Prüfungen,
                 :eDoc Dokumenten,
                 :eEv Prüfungen,
                 :eQu Befähigten Personen,
                 :eIn Eingewiesenen Personen und
                 :ePa Parameter
                 erfolgreich gelöscht',
                [
                    'eCon' => $objects['eCon'],
                    'eDoc' => $objects['eDoc'],
                    'eEv' => $objects['eEv'],
                    'eQu' => $objects['eQu'],
                    'eIn' => $objects['eIn'],
                    'ePa' => $objects['ePa'],
                ]);
        } else {
            $msg = __('Geräte konnte nicht erfolgreich gelöscht werden');
        }

        request()->session()->flash('status',
            $msg);

        return redirect()->route('equipMain');
    }

    public function getEquipmentAjaxListe(Request $request)
    {
        return DB::table('equipment')
            ->select('eq_inventar_nr',
                'equipment.id',
                'equipment.eq_serien_nr',
                'prod_name')
            ->join('produkts',
                'produkts.id',
                '=',
                'equipment.produkt_id')
            ->where('eq_serien_nr',
                'ILIKE',
                '%'.strtolower($request->term).'%')
            ->orWhere('eq_name',
                'ILIKE',
                '%'.strtolower($request->term).'%')
            ->orWhere('eq_inventar_nr',
                'ILIKE',
                '%'.strtolower($request->term).'%')
            //  ->orWhere('eq_uid(?)',t, 'ILIKEolower($request->term) . '%')
            ->orWhere('prod_nummer',
                'ILIKE',
                '%'.strtolower($request->term).'%')
            ->orWhere('prod_name',
                'ILIKE',
                '%'.strtolower($request->term).'%')
            ->orWhere('prod_label',
                'ILIKE',
                '%'.strtolower($request->term).'%')
            ->orWhere('prod_description',
                'ILIKE',
                '%'.strtolower($request->term).'%')
            ->get();
    }
}
