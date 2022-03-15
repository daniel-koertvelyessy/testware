<?php

    namespace App\Http\Controllers;

    use App\Anforderung;
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
    use App\FirmaProdukt;
    use App\ProductInstructedUser;
    use App\ProductQualifiedUser;
    use App\Produkt;
    use App\ProduktAnforderung;
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
         * @return Application|Factory|\Illuminate\Contracts\View\View
         */
        public function index()
        {
            return view('testware.equipment.index');
        }

        /**
         * Show the form for creating a new resource.
         *
         * @param Request $request
         *
         * @return Application|Factory|Response|View
         */
        public function create(Request $request)
        {

            $companyList = FirmaProdukt::where('produkt_id', $request->produkt_id)->get();
            return view('testware.equipment.create', [
                'pk'        => $request->pk,
                'produkt'   => Produkt::find(request('produkt_id')),
                'companies' => $companyList
            ]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         *
         * @return RedirectResponse
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
                'eq_price'           => 'nullable|numeric',
                'installed_at'       => 'date',
                'purchased_at'       => 'date',
                'produkt_id'         => '',
                'storage_id'         => 'required',
                'equipment_state_id' => 'required'
            ]);

            if (isset($request->warranty_expires_at)) {
                $request->validate([
                    'installed_at'        => 'date',
                    'warranty_expires_at' => 'after:installed_at|date_format:Y-m-d',
                ]);
            }

            if (isset($request->setRequirementToProduct)){
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
            if (!$request->hasFile('equipDokumentFile')) $equipment_state_id = 4;
            $equipment->equipment_state_id = $equipment_state_id;

            $equipment->save();

            (new EquipmentUid)->addNew($request->eq_uid, $equipment->id);

            (new EquipmentHistory)->add(__('Gerät angelegt'), __('Das Gerät mit der Inventar-Nr :invno wurde angelegt', ['invno' => request('eq_inventar_nr')]), $equipment->id);

            if (isset($request->warranty_expires_at))
                (new EquipmentWarranty)->addEquipment($request->warranty_expires_at, $equipment->id);


       /*     foreach (Produkt::find($request->produkt_id)->ProduktAnforderung as $prodAnforderung) {

                $dueDate = (new ControlEquipment)->addEquipment($prodAnforderung, $equipment->id, $request);

                (new EquipmentHistory)->add(__('Anforderung angelegt'), __('Für das Geräte wurde die Anforderung :anname angelegt, welche am :duedate zum ersten Mal fällig wird.', [
                    'anname'  => $prodAnforderung->Anforderung->an_name,
                    'duedate' => $dueDate
                ]), $equipment->id);

            }*/

            foreach (ProductQualifiedUser::where('produkt_id', $request->produkt_id)->get() as $productQualifiedUser) {
                (new EquipmentQualifiedUser)->addEquipment($productQualifiedUser, $equipment->id);
            }

            foreach (ProductInstructedUser::where('produkt_id', $request->produkt_id)->get() as $productInstructedUser) {
                (new EquipmentInstruction)->addEquipment($productInstructedUser, $equipment->id);
            }

            if (isset($request->pp_id) && count($request->pp_id) > 0) {
                for ($i = 0; $i < count($request->pp_id); $i++) (new EquipmentParam)->addEquipment($request->pp_id[$i], $request->ep_value[$i], $equipment->id);
            }

            $request->session()->flash('status', __('Das Gerät <strong>:eqname</strong> wurde angelegt!', ['eqname' => request('eq_name')]));


            return redirect()->route('control.manual', [
                'equipment' => $equipment,
                'requirement' => Anforderung::find($request->anforderung_id)
            ]);
        }

        /**
         * Display the specified resource.
         *
         * @param Equipment $equipment
         *
         * @return Application|Factory|\Illuminate\Contracts\View\View
         */
        public function show(Equipment $equipment)
        {
            foreach (EquipmentDoc::where('equipment_id', $equipment->id)->where('document_type_id', 2)->get() as $equipmentDocFile) {
                if (Storage::disk('local')->missing($equipmentDocFile->eqdoc_name_pfad)) {
                    Log::warning('Dateireferenz für Funktionsprüfung (' . $equipmentDocFile->eqdoc_name_pfad . ') aus DB EquipmentDoc existiert nicht auf dem Laufwerk. Datensatz wird gelöscht!');
//                dump('delete '. $equipmentDocFile->eqdoc_name_pfad);
                    $equipmentDocFile->delete();
                }

            }

            foreach (ProduktDoc::where('produkt_id', $equipment->Produkt->id)->where('document_type_id', 1)->get() as $productDocFile) {
                if (Storage::disk('local')->missing($productDocFile->proddoc_name_pfad)) {
                    Log::warning('Dateireferenz (' . $productDocFile->proddoc_name_pfad . ') aus DB EquipmentDoc existiert nicht auf dem Laufwerk. Datensatz wird gelöscht!');
//                dump('delete '. $productDocFile->eqdoc_name_pfad);
                    $productDocFile->delete();
                }

            }

            $companyString = '';
            foreach ($equipment->produkt->firma as $firma) {
                $companyString .= $firma->fa_name . ' ';
            }

            return view('testware.equipment.show', [
                'equipment'     => $equipment,
                'companyString' => $companyString
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param Equipment $equipment
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
         * @param Request $request
         * @param Equipment $equipment
         *
         * @return Application|Factory|RedirectResponse|View
         */
        public function update(Request $request, Equipment $equipment)
        {
            $oldEquipment = Equipment::find($request->id);
            $changedPrameter = [];


            $feld = '';
            $flag = false;
            $feld .= __(':user führte folgende Änderungen durch', ['user' => Auth::user()->username]) . ': <ul>';
            if ($oldEquipment->eq_serien_nr != $request->eq_serien_nr) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Seriennummer'),
                        'old' => $oldEquipment->eq_serien_nr,
                        'new' => $request->eq_serien_nr,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->eq_qrcode != $request->eq_qrcode) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('QR Code'),
                        'old' => $oldEquipment->eq_qrcode,
                        'new' => $request->eq_qrcode,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->eq_name != $request->eq_name) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Name'),
                        'old' => $oldEquipment->eq_name,
                        'new' => $request->eq_name,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->purchased_at != $request->purchased_at) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Kaufdatum'),
                        'old' => $oldEquipment->purchased_at,
                        'new' => $request->purchased_at,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->installed_at != $request->installed_at) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Inbetriebnahme am'),
                        'old' => $oldEquipment->installed_at,
                        'new' => $request->installed_at,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->eq_text != $request->eq_text) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Beschreibung'),
                        'old' => $oldEquipment->eq_text,
                        'new' => $request->eq_text,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->equipment_state_id != $request->equipment_state_id) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Geräte Status'),
                        'old' => $oldEquipment->equipment_state_id,
                        'new' => $request->equipment_state_id,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->storage_id != $request->storage_id) {
                $feld .= '<li>' . __('Feld :fld von [:old] in [:new] geändert', [
                        'fld' => __('Aufstellplatz / Standort'),
                        'old' => $oldEquipment->storage->storage_label?? __('ohne Zuordnung'),
                        'new' => \App\Storage::find($request->storage_id)->storage_label,
                    ]) . '</li>';
                $flag = true;
            }
            if ($oldEquipment->produkt_id != $request->produkt_id) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Produkt'),
                        'old' => $oldEquipment->produkt_id,
                        'new' => $request->produkt_id,
                    ]) . '</li>';
                $flag = true;
            }

            if ($oldEquipment->eq_price != $request->eq_price) {
                $feld .= '<li>' . __('Feld :fld von :old in :new geändert', [
                        'fld' => __('Kaufpreis'),
                        'old' => $oldEquipment->eq_price,
                        'new' => $request->eq_price,
                    ]) . '</li>';
                $flag = true;
            }



            if (isset($request->eqp_id)) {

                foreach ($request->eqp_id as $parameter_id) {
                    $parameter = EquipmentParam::find($parameter_id);
                    $parameter->ep_value = $request->eqp_value[$parameter_id];
                    if ($parameter->save() && $parameter->ep_value !== $request->eqp_value[$parameter_id]) {
                        $changedPrameter[] = [$parameter_id => $request->eqp_value[$parameter_id]];
                        $feld .= __('<li>:num Parameter :name geändert</li>', ['num'  => count($changedPrameter),
                                                                               'name' => $parameter->ep_name
                        ]);
                    }
                }

            }

            $feld .= '</ul>';


            if ($flag || count($changedPrameter) > 0) {
                $equipment->update($this->validateEquipment());
                (new EquipmentHistory)->add(__('Gerät geändert'), $feld, $equipment->id);
                $msg = __('Das Gerät <strong>:equipName</strong> wurde aktualisiert!', ['equipName' => request('eq_inventar_nr')]);
            } else {
                $msg = __('Es wurden keine Änderungen festgestellt.');
            }

            $request->session()->flash('status', $msg);
            return redirect()->route('equipment.show', $equipment);
        }


        /**
         * @return array
         */
        public function validateEquipment(): array
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
                'eq_name'            => '',
                'eq_qrcode'          => '',
                'eq_text'            => '',
                'eq_price'           => 'nullable|numeric',
                'installed_at'       => 'date',
                'purchased_at'       => 'date',
                'produkt_id'         => '',
                'storage_id'         => 'required',
                'equipment_state_id' => 'required'
            ],[
                'eq_inventar_nr.required' => __('Ein Geräte mit dieser Inventarnummer existiert bereits!'),
                'eq_serien_nr.required' => __('Ein Gerät mit dieser Seriennummer existiert bereits!'),
 //               'eq_price.numberic' => __('Ein Gerät mit dieser Seirennummer existiert bereits!'),
            ]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Equipment $equipment
         *
         * @return RedirectResponse
         * @throws Exception
         */
        public function destroy(Equipment $equipment): RedirectResponse
        {
            foreach (EquipmentDoc::where('equipment_id', $equipment->id)->get() as $prodDoku) {
                EquipmentDoc::find($prodDoku->id);
                Storage::delete($prodDoku->proddoc_name_pfad);
                $prodDoku->delete();
            }

            $equipment->delete();

            return redirect()->route('equipMain');
        }

        public function getEquipmentAjaxListe(Request $request)
        {
            return DB::table('equipment')
                ->select('eq_inventar_nr', 'equipment.id', 'equipment.eq_serien_nr', 'prod_name')
                ->join('produkts', 'produkts.id', '=', 'equipment.produkt_id')
                ->whereRaw('LOWER(eq_serien_nr) LIKE ?', '%' . strtolower($request->term) . '%')
                ->orWhereRaw('LOWER(eq_inventar_nr) LIKE ?', '%' . strtolower($request->term) . '%')
                ->orWhereRaw('LOWER(eq_uid) LIKE ?', '%' . strtolower($request->term) . '%')
                ->orWhereRaw('LOWER(prod_nummer) LIKE ?', '%' . strtolower($request->term) . '%')
                ->orWhereRaw('LOWER(prod_name) LIKE ?', '%' . strtolower($request->term) . '%')
                ->orWhereRaw('LOWER(prod_label) LIKE ?', '%' . strtolower($request->term) . '%')
                ->orWhereRaw('LOWER(prod_description) LIKE ?', '%' . strtolower($request->term) . '%')
                ->get();
        }
    }
