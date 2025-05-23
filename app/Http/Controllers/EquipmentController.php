<?php

namespace App\Http\Controllers;

use App\Anforderung;
use App\ControlEquipment;
use App\ControlInterval;
use App\DocumentType;
use App\Equipment;
use App\EquipmentHistory;
use App\EquipmentQualifiedUser;
use App\EquipmentState;
use App\EquipmentUid;
use App\EquipmentWarranty;
use App\FirmaProdukt;
use App\Http\Actions\Equipment\EquipmentAction;
use App\Http\Services\Equipment\EquipmentDocumentService;
use App\Http\Services\Equipment\EquipmentEventService;
use App\Http\Services\Equipment\EquipmentService;
use App\Produkt;
use App\ProduktDoc;
use App\Storage;
use App\User;
use App\ViewModel\EquipmentViewModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Str;

class EquipmentController extends Controller
{
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
        return view('testware.equipment.index', [
            'equipmentlist' => Equipment::with('ControlEquipment')->sortable()->paginate(10),
            'header' => __('Übersicht Geräte'),
        ]);
    }

    public function controlequipment()
    {
        $service = new EquipmentEventService;

        return view('testware.equipment.index', [
            'equipmentlist' => $service->makeEquipmentControlCollection(),
            'header' => __('Übersicht Prüfgeräte'),
        ]);
    }

    public function main(): View
    {

        //        $equipmentList = Equipment::query()->select([
        //            'id',
        //            'eq_name',
        //            'eq_inventar_nr',
        //            'equipment_state_id',
        //            'eq_uid',
        //            'storage_id'
        //        ])->with([
        //            'Produkt.ControlProdukt',
        //            'Produkt',
        //            'storage',
        //            'EquipmentState',
        //            'EquipmentQualifiedUser',
        //            'ControlEquipment',
        //        ])->withCount(['ControlEquipment as tested_count' => fn($q) => $q->onlyTrashed()])->sortable()->paginate(10);
        //
        //        $equipmentViewModels = EquipmentViewModel::collection($equipmentList);
        //
        //        return view('testware.equipment.main', [
        //            'equipmentList'       => $equipmentList,
        //            'equipmentViewModels' => $equipmentViewModels,
        //        ]);

        $equipmentList = Equipment::query()->select([
            'id',
            'eq_name',
            'eq_inventar_nr',
            'equipment_state_id',
            'eq_uid',
            'storage_id',
        ])->with([
            'produkt.controlprodukt',
            'storage',
            'EquipmentState',
            'EquipmentQualifiedUser',
            'ControlEquipment.Anforderung',
        ])->withCount(['ControlEquipment as tested_count' => fn ($q) => $q->onlyTrashed()])->sortable()->paginate(10);

        // Replace the internal collection with ViewModels, keep pagination
        $equipmentList->setCollection(EquipmentViewModel::collection($equipmentList->getCollection()));

        return view('testware.equipment.main', [
            'equipmentList' => $equipmentList,
            // Now contains EquipmentViewModels
        ]);

    }

    public function statuslist(EquipmentState $equipmentState)
    {

        return view('testware.equipment.state_list', [
            'equipmentList' => Equipment::with('ControlEquipment', 'storage', 'EquipmentState')->where('equipment_state_id', $equipmentState->id)->get(),
            'status_label' => $equipmentState->estat_label,
        ]);

    }

    public function create(Request $request)
    {

        $companyList = FirmaProdukt::where('produkt_id', $request->produkt_id)->get();

        return view('testware.equipment.create', [
            'pk' => $request->pk,
            'produkt' => Produkt::with('ProduktAnforderung')->find(request('produkt_id')),
            'companies' => $companyList,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $service = new EquipmentService;

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

        $equipment = new Equipment;
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
        if (! $request->hasFile('equipDokumentFile')) {
            $equipment_state_id = 4;
        }
        $equipment->equipment_state_id = $equipment_state_id;

        $equipment->save();

        (new EquipmentUid)->addNew($request->eq_uid, $equipment->id);

        (new EquipmentHistory)->add(__('Gerät angelegt'), __('Das Gerät mit der Inventar-Nr :invno wurde angelegt', ['invno' => request('eq_inventar_nr')]), $equipment->id);

        if (isset($request->warranty_expires_at)) {
            (new EquipmentWarranty)->addEquipment($request->warranty_expires_at, $equipment->id);
        }

        $service->transferProductQualifiedUser($request, $equipment);

        $service->transferProductInstructedUser($request, $equipment);

        $service->transferProductParameters($request, $equipment);

        $request->session()->flash('status', __('Das Gerät <strong>:eqname</strong> wurde angelegt!', ['eqname' => request('eq_name')]));

        return redirect()->route('control.manual', [
            'equipment' => $equipment,
            'requirement' => Anforderung::find($request->anforderung_id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(Equipment $equipment)
    {

        $serviceDocument = new EquipmentDocumentService;

        $service = new EquipmentService;

        EquipmentAction::deleteLoseEquipmentDocumentEntries($equipment);

        EquipmentAction::deleteLoseProductDocumentEntries($equipment);

        EquipmentAction::deleteLoseRequirementEntries($equipment);

        $storage = Storage::find($equipment->storage_id);

        if ($storage) {
            $value = $storage->getStoragePath();
        } else {
            $value = __('nicht zugeordnet');
        }

        return view('testware.equipment.show', [
            'userList' => User::select('id', 'name')->get(),
            'productDocuments' => ProduktDoc::where('produkt_id', $equipment->produkt_id)->get(),
            'controlIntervalList' => ControlInterval::select('id', 'ci_label')->get(),
            'qualifiedUserList' => EquipmentQualifiedUser::with('firma', 'user')->where('equipment_id', $equipment->id)->get(),
            'loggedInUserIsQualified' => $service->checkUserQualified($equipment),
            'upcomingControlList' => $service->getUpcomingControlItems($equipment),
            'onetimeControlList' => $service->getOneTimeControlItems($equipment),
            'controlList' => $service->getAllControlItems($equipment),
            'instructedPersonList' => $service->getInstruectedPersonList($equipment),
            'equipmentRequirementList' => $service->getRequirementList($equipment),
            'requirementList' => Anforderung::select([
                'id',
                'an_label',
            ])->get(),
            'recentControlList' => $service->getRecentExecutedControls($equipment),
            'euqipmentDocumentList' => $serviceDocument->getDocumentList($equipment),
            'functionDocumentList' => $serviceDocument::getFunctionTestDocumentList($equipment),
            'newFileList' => $serviceDocument->checkStorageSyncDB($equipment),
            'companyString' => $service->makeCompanyString($equipment),
            'equipment' => $equipment,
            'parameterListItems' => $service->getParamList($equipment),
            'locationpath' => $value,
            'isSysadmin' => Auth::user()->isSysAdmin(),
            'documentTypes' => DocumentType::all(),
            //            'intervalTypeList'         => ControlInterval::select('id', 'ci_label')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
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
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function update(Request $request, Equipment $equipment)
    {

        $changedItems = (new EquipmentService)->checkUpdatedFields($request, Equipment::find($request->id));

        if ($changedItems['changedStatus'] || count($changedItems['changedPrameter']) > 0) {
            $equipment->update($this->validateEquipment());
            (new EquipmentHistory)->add(__('Gerät geändert'), $changedItems['changedItems'], $equipment->id);
            $msg = __('Das Gerät <strong>:equipName</strong> wurde aktualisiert!', ['equipName' => request('eq_inventar_nr')]);
        } else {
            $msg = __('Es wurden keine Änderungen festgestellt.');
        }

        $request->session()->flash('status', $msg);

        return redirect()->route('equipment.show', $equipment);
    }

    public function validateEquipment(): array
    {
        return request()->validate([
            'eq_inventar_nr' => [
                'bail',
                'max:250',
                'required',
                Rule::unique('equipment')->ignore(request('id')),
            ],
            'eq_serien_nr' => [
                'bail',
                'nullable',
                'max:250',
                Rule::unique('equipment')->ignore(request('id')),
            ],
            'eq_uid' => [
                'bail',
                'required',
                Rule::unique('equipment')->ignore(request('id')),
            ],
            'eq_name' => '',
            'eq_qrcode' => '',
            'eq_text' => '',
            'eq_price' => 'nullable|numeric',
            'installed_at' => 'date',
            'purchased_at' => 'date',
            'produkt_id' => '',
            'storage_id' => 'required',
            'equipment_state_id' => 'required',
        ], [
            'eq_inventar_nr.required' => __('Ein Geräte mit dieser Inventarnummer existiert bereits!'),
            'eq_serien_nr.required' => __('Ein Gerät mit dieser Seriennummer existiert bereits!'),
            //               'eq_price.numberic' => __('Ein Gerät mit dieser Seirennummer existiert bereits!'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {

        /**
         * Delete all related objects first
         */
        $objects = EquipmentAction::deleteRelatedObjetcs($equipment);

        /**
         * Since the deletion of the equipment will set the deleted_at field with a timestamp
         * rather than deleting the database entry itself, the serial number and invertory id
         * recieve a postfix to prevent the unique violation of the fields.
         */
        $equipment->eq_serien_nr = substr($equipment->eq_serien_nr.'|'.Str::uuid(), 0, 250);
        $equipment->eq_inventar_nr = substr($equipment->eq_inventar_nr.'|'.Str::uuid(), 0, 250);
        $equipment->save();

        if ($equipment->delete()) {
            $msg = __('Geräte wurde mit
                 :eCon Prüfungen,
                 :eDoc Dokumenten,
                 :eEv Prüfungen,
                 :eQu Befähigten Personen,
                 :eIn Eingewiesenen Personen und
                 :ePa Parameter
                 erfolgreich gelöscht', [
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

        request()->session()->flash('status', $msg);

        return redirect()->route('equipMain');
    }

    public function fixuid(Request $request)
    {
        $changeCounter = 0;
        foreach ($request->keepThisUid as $uid => $id) {

            foreach (Equipment::where('eq_uid', $uid)->get() as $equipment) {

                if ($equipment->id != $id) {
                    $equipment->eq_uid = \Illuminate\Support\Str::uuid();
                    if ($equipment->save()) {
                        $changeCounter++;
                    }
                }

            }

        }

        $request->session()->flash('status', __('Es wurden :num Uid geändert!', ['num' => $changeCounter]));

        return back();
    }

    public function syncuid()
    {

        $syncCounter = 0;
        $newCounter = 0;

        foreach (Equipment::select('id', 'eq_uid')->get() as $equipment) {

            $equipmentUid = EquipmentUid::where('equipment_id', $equipment->id)->where('equipment_uid', $equipment->eq_uid)->first();

            if ($equipmentUid) {
                if ($equipmentUid->equipment_uid !== $equipment->eq_uid) {
                    $equipmentUid->equipment_uid = $equipment->eq_uid;
                    $syncCounter += $equipmentUid->save()
                        ? 1
                        : 0;
                }
            } elseif (EquipmentUid::where('equipment_id', $equipment->id)->count() > 0) {
                $checkIdOnly = EquipmentUid::where('equipment_id', $equipment->id)->first();
                if ($checkIdOnly) {
                    if ($checkIdOnly->equipment_uid !== $equipment->eq_uid) {
                        $checkIdOnly->equipment_uid = $equipment->eq_uid;
                        $syncCounter += $checkIdOnly->save()
                            ? 1
                            : 0;
                    }
                }
            } else {
                $new_equipment_uid = new EquipmentUid;
                $new_equipment_uid->equipment_id = $equipment->id;
                $new_equipment_uid->equipment_uid = $equipment->eq_uid;
                $newCounter += $new_equipment_uid->save()
                    ? 1
                    : 0;
            }

        }
        if ($syncCounter > 0) {
            $msg = $syncCounter > 1
                ? __('Es wurden :numSync Einträge synchronisiert!', ['numSync' => $syncCounter])
                : __('Es wurde ein Eintrag synchronisiert.');
        }

        if ($newCounter > 0) {
            $msg .= $newCounter > 1
                ? __('Es wurden :numNew Einträger vorgenommen!', ['numNew' => $newCounter])
                : __('Es wurde ein neuer Eintrag erstellt.');
        }

        request()->session()->flash('status', $msg);

        return back();

    }

    public function syncRequirements(Request $request)
    {

        // dd($request);
        $countr = 0;
        foreach ($request->anforderung_id as $key => $id) {
            $controlEquipment = new ControlEquipment;
            $controlEquipment->equipment_id = $request->equipment_id[$key];
            $controlEquipment->anforderung_id = $request->anforderung_id[$key];
            $controlEquipment->qe_control_date_last = $request->qe_control_date_last[$key];
            $controlEquipment->qe_control_date_due = $request->qe_control_date_due[$key];
            $controlEquipment->qe_control_date_warn = $request->qe_control_date_warn[$key];
            $controlEquipment->control_interval_id = $request->control_interval_id[$key];
            $countr += $controlEquipment->save()
                ? 1
                : 0;
        }

        (new EquipmentHistory)->add(__('Anforderungen synchronisieren'), trans('Insgesamt :num Anforderungen wuden synchronisiert.', ['num' => $countr]), $request->equipment_id[0]);

        $msg = $countr > 1
            ? __('Es wurden :num Prüfungen angelegt', ['num' => $countr])
            : __('Es wurde eine Prüfung angelegt');

        $request->session()->flash('status', $msg);

        return back();

    }

    public function getEquipmentAjaxListe(Request $request)
    {
        return DB::table('equipment')->select('eq_inventar_nr', 'equipment.id', 'equipment.eq_serien_nr', 'prod_name')->join('produkts', 'produkts.id', '=', 'equipment.produkt_id')->where('eq_serien_nr', 'ILIKE', '%'.strtolower($request->term).'%')->orWhere('eq_name', 'ILIKE', '%'.strtolower($request->term).'%')->orWhere('eq_inventar_nr', 'ILIKE', '%'.strtolower($request->term).'%')
            //  ->orWhere('eq_uid(?)',t, 'ILIKEolower($request->term) . '%')
            ->orWhere('prod_nummer', 'ILIKE', '%'.strtolower($request->term).'%')->orWhere('prod_name', 'ILIKE', '%'.strtolower($request->term).'%')->orWhere('prod_label', 'ILIKE', '%'.strtolower($request->term).'%')->orWhere('prod_description', 'ILIKE', '%'.strtolower($request->term).'%')->get();
    }
}
