<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Anforderung;
use App\Contact;
use App\ControlEquipment;
use App\ControlProdukt;
use App\Equipment;
use App\EquipmentHistory;
use App\EquipmentLabel;
use App\EquipmentParam;
use App\Firma;
use App\FirmaProdukt;
use App\Http\Services\Product\ProductService;
use App\Produkt;
use App\ProduktAnforderung;
use App\ProduktDoc;
use App\ProduktKategorie;
use App\ProduktKategorieParam;
use App\ProduktParam;
use Cache;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProduktController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->middleware('auth');
        $this->service = new ProductService;
    }

    /**
     * Führt zur Übersichtsseite Produkt
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $produktList = Produkt::with('ProduktKategorie', 'ProduktState', 'ProductQualifiedUser', 'ProduktAnforderung', 'ControlProdukt')->sortable()->paginate(10);

        return view('admin.produkt.index', [
            'produktList' => $produktList,
            'isSysAdmin' => Auth::user()->isSysAdmin(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create(Request $request)
    {
        return view('admin.produkt.create', ['pk' => $request->pk]);
    }

    /**
     * Führt zur Importseite für Produkte
     *
     * @return Application|Factory|Response|View
     */
    public function importProdukt()
    {
        //        $this->authorize('isAdmin', Auth()->user());
        return view('admin.produkt.import');
    }

    /**
     * Führt zur Exportseite für Produkte
     *
     * @return Application|Factory|Response|View
     */
    public function exportProdukt()
    {
        //        $this->authorize('isAdmin', Auth()->user());
        return view('admin.produkt.export');
    }

    /**
     * Display the specified resource.
     *
     *
     * @return Application|Factory|Response|View
     */
    public function show(Produkt $produkt)
    {

        $this->service->deleteEmptyStorageDBItems($produkt);

        return view('admin.produkt.show', [
            'instructedUserList' => $this->service->getInstructedUserList($produkt),
            'qualifiedUserList' => $this->service->getProductQualifiedUserList($produkt),
            'hasQualifiedUser' => $this->service->hasQualifiedUsers($produkt),
            'hasExternalSupplier' => $this->service->hasExternalSupplier($produkt),
            'requirementList' => $this->service->getRequirementList($produkt),
            'produkt' => $produkt,
            'labels' => EquipmentLabel::all(),
            'params' => $produkt->ProduktParam,
            'equipLists' => $this->service->getChildEquipmentList($produkt),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProduktParam ProduktParam
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Produkt $produkt)
    {

        //        $this->authorize('isAdmin', Auth()->user());
        if (isset($request->control_product)) {
            ControlProdukt::updateOrInsert(['produkt_id' => $request->id]);
        } else {
            ControlProdukt::where('produkt_id', $request->id)->delete();
        }

        $produkt->prod_active = $request->has('prod_active')
            ? 1
            : 0;

        //            dd($request);

        $produkt->update($this->validateProdukt($request));

        //        dd(isset($request->pp_label));
        if (isset($request->pp_label) && count($request->pp_label) > 0) {
            for ($i = 0; $i < count($request->pp_label); $i++) {
                $param = ProduktParam::find($request->pp_id[$i]);
                $param->pp_value = $request->pp_label[$i];
                $param->save();
            }
        }

        $request->session()->flash('status', 'Das Produkt <strong>'.$produkt->prod_nummer.'</strong> wurde aktualisiert!');

        return redirect($produkt->path());
    }

    public function validateProdukt(): array
    {
        return request()->validate([
            'prod_label' => [
                'bail',
                'min:2',
                'max:20',
                'required',
                Rule::unique('produkts')->ignore(request('id')),
            ],
            'prod_uuid' => '',
            'prod_name' => '',
            'prod_description' => '',
            'prod_nummer' => [
                'bail',
                'required',
                'max:100',
                Rule::unique('produkts')->ignore(request('id')),
            ],
            'prod_active' => '',
            'produkt_kategorie_id' => 'nullable',
            'equipment_label_id' => '',
            'produkt_state_id' => 'required',
        ]);
    }

    /**
     * Speichere neuen Produktstamm
     *
     *
     * @return Application|Response
     *
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {

        $produkt = Produkt::create($this->validateProdukt());

        if (isset($request->pp_label) && count($request->pp_label) > 0) {

            for ($i = 0; $i < count($request->pp_label); $i++) {
                $param = new ProduktParam;

                $param->produkt_id = $produkt->id;
                $param->pp_label = $request->pp_label[$i];
                $param->pp_name = $request->pp_name[$i];
                $param->pp_value = $request->pp_value[$i];
                $param->save();
            }
        }

        if (request()->has('control_product')) {
            $controlProduct = new ControlProdukt;
            $controlProduct->produkt_id = $produkt->id;
            $controlProduct->save();
        }

        $request->session()->flash('status', __('Das Produkt <strong>:label</strong> wurde angelegt!', ['label' => request('prod_nummer')]));

        return redirect($produkt->path());
    }

    public function ajaxstore(Request $request)
    {

        if (isset($request->produkt_kategorie_id) && $request->produkt_kategorie_id === 'new') {
            $prodKat = new ProduktKategorie;
            $prodKat->pk_label = $request->newProduktKategorie;
            $prodKat->save();
            $produkt_kategorie_id = $prodKat->id;
        } else {
            $produkt_kategorie_id = $request->produkt_kategorie_id;
        }
        $this->validateProdukt();
        $produkt = new Produkt;
        $produkt->prod_uuid = Str::uuid();
        $produkt->prod_label = $request->prod_label;
        $produkt->prod_name = $request->prod_name;
        $produkt->produkt_state_id = $request->produkt_state_id;
        $produkt->prod_active = $request->prod_active;
        $produkt->prod_nummer = $request->prod_nummer;
        $produkt->prod_description = $request->prod_description;
        $produkt->produkt_kategorie_id = $produkt_kategorie_id;
        $produkt->save();

        if (request()->has('control_product')) {
            $controlProduct = new ControlProdukt;
            $controlProduct->produkt_id = $produkt->id;
            $controlProduct->save();
        }
        $produkt_id = $produkt->id;

        if (is_array($request->anforderung_id)) {
            for ($i = 0; $i < count($request->anforderung_id); $i++) {
                $prodAnfor = new ProduktAnforderung;
                $prodAnfor->produkt_id = $produkt_id;
                $prodAnfor->anforderung_id = $request->anforderung_id[$i];
                $prodAnfor->save();
            }
        }

        if ($request->hasFile('prodDokumentFile')) {

            $proDocFile = new ProduktDoc;
            $file = $request->file('prodDokumentFile');
            $this->validateProduktDokument();
            $request->validate([
                'prodDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg,gif,svg',
                // size:2048 => 2048kB
            ]);

            $proDocFile->proddoc_name = $file->getClientOriginalName();
            $proDocFile->proddoc_name_pfad = $file->store('produkt_docu/'.$produkt_id);
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->produkt_id = $produkt_id;
            $proDocFile->proddoc_description = request('proddoc_description');
            $proDocFile->proddoc_label = request('proddoc_label');
            $proDocFile->save();
        }

        return redirect()->route('equipment.create', ['produkt_id' => $produkt->id]);
    }

    public function validateProduktDokument(): array
    {
        return request()->validate([
            'proddoc_label' => 'bail|required|max:150',
            'proddoc_name' => 'max:100',
            'proddoc_name_pfad' => 'max:150',
            'document_type_id' => 'required',
            'proddoc_description' => '',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Produkt $produkt, Request $request)
    {

        $produkt->delete();
        $request->session()->flash('status', __('Das Produkt wurde gelöscht!'));

        return redirect(route('produkt.index'));
    }

    /**
     * Copy the specified resource including .
     *
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function copy(Produkt $produkt, Request $request) {}

    /**
     * Bind a company to a given product.
     *
     *
     * @return Application|RedirectResponse|Response|Redirector
     *
     * @throws AuthorizationException
     */
    public function addProduktFirma(Request $request): RedirectResponse
    {

        $address_id = false;
        $firma_id = false;

        $st = [];

        $st['request'] = $request;

        if (isset($request->ckAddNewAddress)) {

            $this->validateAdresse();
            $addresse = new Adresse;
            $addresse->ad_label = $request->ad_label;
            $addresse->ad_anschrift_strasse = $request->ad_anschrift_strasse;
            $addresse->ad_anschrift_plz = $request->ad_anschrift_plz;
            $addresse->ad_anschrift_ort = $request->ad_anschrift_ort;
            $addresse->ad_anschrift_hausnummer = $request->ad_anschrift_hausnummer;
            $addresse->land_id = $request->land_id;
            $addresse->address_type_id = $request->address_type_id;
            $addresse->ad_name_firma = $request->fa_name;
            $addresse->save();

            $address_id = $addresse->id;
            $st['add'][] = 'Neue Adresse anlegen';
            //            $address_id = 12;
        }

        if (isset($request->ckAddNewFirma)) {
            $st['firma'][] = 'Neue Firma anlegen';
            //            $firma_id = 59;
            if ($address_id !== false) {
                $st['firma'][] = '$address_id -> '.$address_id;
                $this->validateFirma();
                $fa = new Firma;
                $fa->fa_label = $request->fa_label;
                $fa->fa_name = $request->fa_name;
                $fa->fa_kreditor_nr = $request->fa_kreditor_nr;
                $fa->fa_debitor_nr = $request->fa_debitor_nr;
                $fa->fa_vat = $request->fa_vat;
                $fa->adresse_id = $address_id;
                $fa->save();
                $firma_id = $fa->id;
            } else {
                $st['firma'][] = '$address_id wird übernommen ->'.$request->adress_id;
                $firma = Firma::create($this->validateFirma());
                $firma_id = $firma->id;
            }

            $st['FirmaProdukt'][] = 'Baue neues FirmaProdukt aus neuer Firma';
            $faprod = new FirmaProdukt;
            $faprod->firma_id = $firma_id;
            $faprod->produkt_id = $request->produkt_id;
            $faprod->save();
        } else {
            $st['FirmaProdukt'][] = 'Baue neue FirmaProdukt aus bestehender Firma';
            if ($this->checkProduktFirmaExists($request->firma_id, $request->produkt_id)) {
                $request->session()->flash('status', __('Die Firma :name ist bereits zugeordnet!', ['name' => $request->fa_name]));

                return redirect()->back();
            } else {
                FirmaProdukt::create($this->validateFirmaProdukt());
            }
        }

        if (isset($request->ckAddNewContact)) {
            if ($firma_id) {
                $st['contact'] = 'Baue neuen Kontakt mit neuer Firma';
                $this->validateContact();

                $con = new Contact;

                $con->con_label = $request->con_label;
                $con->con_vorname = $request->con_vorname;
                $con->con_name = $request->con_name;
                $con->con_telefon = $request->con_telefon;
                $con->con_email = $request->con_email;
                $con->anrede_id = $request->anrede_id;
                $con->firma_id = $firma_id;
                $con->save();
            } else {
                $st['contact'] = 'Baue neuen Kontakt mit bestehender Firma';
                Contact::create($this->validateContact());
            }
        }

        $request->session()->flash('status', __('Das Produkt wurde der Firma :name zugeordnet!', ['name' => $request->fa_name]));

        return redirect()->back();
    }

    protected function checkProduktFirmaExists(int $firma_id, int $produkt_id): bool
    {
        return FirmaProdukt::where([
            'firma_id' => $firma_id,
            'produkt_id' => $produkt_id,
        ])->count() > 0;

    }

    public function validateAdresse(): array
    {
        return request()->validate([
            'ad_label' => [
                'bail',
                'max:20',
                'required',
                Rule::unique('adresses')->ignore(\request('id')),
            ],
            'ad_anschrift_strasse' => 'bail|required|max:100',
            'ad_anschrift_plz' => 'bail|required|max:100',
            'ad_anschrift_ort' => 'bail|required|max:100',
            'ad_anschrift_hausnummer' => 'max:100',
            'land_id' => 'max:100',
            'address_type_id' => '',
        ]);
    }

    public function validateFirma(): array
    {
        return request()->validate([
            'fa_label' => [
                'bail',
                'max:20',
                'required',
                Rule::unique('firmas')->ignore(\request('id')),
            ],
            'fa_name' => 'max:100',
            'fa_kreditor_nr' => 'max:100',
            'fa_debitor_nr' => 'max:100',
            'fa_vat' => 'max:30',
            'adress_id' => '',
        ]);
    }

    public function validateFirmaProdukt(): array
    {
        return request()->validate([
            'firma_id' => 'required',
            'produkt_id' => 'required',
        ]);
    }

    public function validateContact(): array
    {
        return request()->validate([
            'con_label' => [
                'bail',
                'max:20',
                'required',
                Rule::unique('contacts')->ignore(\request('id')),
            ],
            'con_vorname' => 'max:100',
            'con_name' => 'max:100',
            'con_telefon' => 'max:100',
            'con_email' => 'max:100',
            'anrede_id' => '',
        ]);
    }

    public function removeFirmaFromProdukt(Request $request)
    {
        //        $this->authorize('isAdmin', Auth()->user());
        $faprod = FirmaProdukt::where([
            [
                'produkt_id',
                request('produktid'),
            ],
            [
                'firma_id',
                request('firmaid'),
            ],
        ])->delete();

        $request->session()->flash('status', __('Die Firma wurde vom Produkt entfernt!'));

        return redirect()->back();
    }

    public function getKategorieProducts($id)
    {

        $prodList = Produkt::where('produkt_kategorie_id', $id)->sortable()->paginate(20);

        return view('admin.produkt.kategorie.index', [
            'prodList' => $prodList,
            'id' => $id,
        ]);
    }

    public function getProduktIdListAll(Request $request)
    {
        return DB::table('produkts')->select('produkts.id', 'prod_nummer', 'prod_name', 'pk_label', 'prod_label')->distinct()->join('produkt_kategories', 'produkts.produkt_kategorie_id', '=', 'produkt_kategories.id')->leftJoin('produkt_params', 'produkts.id', '=', 'produkt_params.produkt_id')->whereRaw('LOWER(prod_label) LIKE ?', '%'.strtolower($request->term).'%')->orWhereRaw('LOWER(prod_name) LIKE ?', '%'.strtolower($request->term).'%')->orWhereRaw('LOWER(prod_description) LIKE ?', '%'.strtolower($request->term).'%')->orWhereRaw('LOWER(prod_nummer) LIKE ?', '%'.strtolower($request->term).'%')->orWhereRaw('LOWER(pp_name) LIKE ?', '%'.strtolower($request->term).'%')->orWhereRaw('LOWER(pp_label) LIKE ?', '%'.strtolower($request->term).'%')->get();
    }

    /**
     *   Liefert die JSON-Daten für die Übersichtstablle in /produkt -> index.blade.php
     *
     *
     * @return array JSON
     */
    public function getProduktListe(Request $request)
    {
        $data = [];
        //        DB::connection()->enableQueryLog();
        $prduktCache = Cache::remember('produkt-liste-kat-'.$request->id, now()->addSeconds(2), function () use ($request) {
            return Produkt::with('ProduktKategorie', 'ProduktState')->where('produkt_kategorie_id', $request->id)->get();
        });
        $produkts = $prduktCache;
        foreach ($produkts as $produkt) {
            $icon = ($produkt->prod_active === 1)
                ? '<i class="fas fa-check text-success"  data-toggle="tooltip" data-placement="top" ></i>'
                : '<i class="fas fa-times text-danger"  data-toggle="tooltip" data-placement="top"></i>';
            $data[] = [
                'term' => $request->id,
                'id' => $produkt->id,
                'prod_kategorie' => $produkt->ProduktKategorie->pk_label,
                'created_at' => date('d.m.Y H:s', strtotime($produkt->created_at)),
                'prod_nummer' => $produkt->prod_nummer,
                'prod_label' => $produkt->prod_label,
                'prod_active' => $icon,
                'prod_status' => '<i class="'.$produkt->ProduktState->ps_icon.' text-'.$produkt->ProduktState->ps_color.'"  data-toggle="tooltip" data-placement="top" title="'.$produkt->ProduktState->ps_name.'"></i>',
                'prod_link' => '<a href="/produkt/'.$produkt->id.'" class="btn btn-outline-secondary btn-sm"><i class="fas fa-angle-right"></i></a>',
            ];
        }

        //        dd(DB::getQueryLog());
        return $data;
    }

    public function getProduktKategorieParams(Request $request)
    {
        $data['htmlList'] = view('components.parameters.pk-paramfield', [
            'params' => ProduktKategorieParam::where('produkt_kategorie_id', $request->id)->get(),
            'mode' => 'edit',
        ])->render();

        return $data;
    }

    public function getUsedProduktsByPK(Request $request)
    {
        return Produkt::where('produkt_kategorie_id', $request->id)->count();
    }

    public function updateProduktKategorieParams(Request $request): RedirectResponse
    {
        /**
         * set counter
         */
        $updated_product_counter = 0;
        $updated_equipment_counter = 0;

        /**
         * Update the parameter itself
         */
        $this->validateProduktKategorieParam();
        $param = ProduktKategorieParam::find($request->id);
        $old_label = $param->pkp_label;
        $old_name = $param->pkp_name;

        $param->pkp_label = $request->pkp_label;
        $param->pkp_name = $request->pkp_name;
        $msg = ($param->save())
            ? __('<p>Der Parameter wurde aktualisiert</p>')
            : __('<p>Keine Aktualisierung</p>');

        if ($request->checkUpdateRelatedObjects) {
            /**
             *  Find related objects and update the parameter as well
             *  First find all related products from that category
             */
            $productList = Produkt::where('produkt_kategorie_id', $request->produkt_kategorie_id);
            if ($productList->count() > 0) {
                $msg .= __('<p>Es wurden :num Produkte in dieser Kategorie gefunden.</p>', ['num' => $productList->count()]);
                foreach ($productList->get() as $product) {
                    /**
                     *  Update the parameter name & label from the respective product
                     */
                    $product_params = ProduktParam::where([
                        [
                            'pp_label',
                            $old_label,
                        ],
                        [
                            'produkt_id',
                            $product->id,
                        ],
                    ]);
                    if ($product_params->count() > 0) {
                        $pp = $product_params->first();
                        $pp->pp_label = $request->pkp_label;
                        $pp->pp_name = $request->pkp_name;
                        if ($pp->save()) {
                            $updated_product_counter++;
                        }
                    }

                    /**
                     *  Find equipment related to the current product and update the respective
                     *  name & label
                     */
                    $equipment_list = Equipment::where('produkt_id', $product->id);
                    $msg .= __('<p>Es wurden :num Geräte in dieser Kategorie gefunden.</p>', ['num' => $equipment_list->count()]);
                    if ($equipment_list->count() > 0) {
                        foreach ($equipment_list->get() as $equipment) {
                            $equipment_params = EquipmentParam::where([
                                [
                                    'ep_label',
                                    $old_label,
                                ],
                                [
                                    'equipment_id',
                                    $equipment->id,
                                ],
                            ]);
                            if ($equipment_params->count() > 0) {
                                $ep = $equipment_params->first();
                                $ep->ep_label = $request->pkp_label;
                                $ep->ep_name = $request->pkp_name;
                                if ($ep->save()) {
                                    $updated_equipment_counter++;
                                    (new EquipmentHistory)->add(__('Parameter Texte aktualisiert'), __('Der Parameter <strong>:paraname</strong> der verknüpfte Produktkategorie wurde in <span class="text-info">:paramNeu</span> geändert. Die Änderung wurde für dieses Gerät übernommen.', [
                                        'paraname' => $old_name,
                                        'paramNeu' => $request->pkp_name,
                                    ]), $equipment->id);
                                }
                            }
                        }
                    }
                }
            } else {
                $msg .= __('<p>Es wurde keine Produkte in dieser Kategorie gefunden.</p>');
            }
        }

        $msg .= __('<p>Es wurden :numProduct Produkte und :numEquipment Geräte aktualisiert</p>', [
            'numProduct' => $updated_product_counter,
            'numEquipment' => $updated_equipment_counter,
        ]);

        $request->session()->flash('status', $msg);

        return back();

    }

    public function validateProduktKategorieParam(): array
    {
        return request()->validate([
            'pkp_label' => [
                'bail',
                'required',
                'max:20',
                Rule::unique('produkt_kategorie_params')->ignore(\request('id')),
            ],
            'pkp_name' => 'bail|string|max:100',
            'pkp_value' => '',
            'produkt_kategorie_id' => 'required',
        ]);
    }

    /**
     * Speichere neuen Produktstamm
     */
    public function addProduktKategorieParam(Request $request): RedirectResponse
    {
        //        $this->authorize('isAdmin', Auth()->user());
        ProduktKategorieParam::create($this->validateProduktKategorieParam());
        $request->session()->flash('status', __('Der Parameter <strong>:name</strong> wurde angelegt!', ['name' => request('pkp_name')]));

        return back();
    }

    /**
     *  Löscht den Param von der Produk-Kategorie
     *
     *
     * @return RedirectResponse
     */
    public function deleteProduktKategorieParam(Request $request)
    {
        //        $this->authorize('isAdmin', Auth()->user());
        ProduktKategorieParam::find($request->id)->delete();
        $request->session()->flash('status', __('Der Parameter <strong>:name</strong> wurde gelöscht!', ['name' => request('pkp_name')]));

        return back();
    }

    /**
     * Fügt neue Kategorie für Produktstamm hinzu
     *
     *
     * @return Application|Response
     */
    public function addProduktKategorie(Request $request)
    {
        $produkt = ProduktKategorie::create($this->validateProduktKategorie());
        $request->session()->flash('status', 'Die Produktkategorie  <strong>'.request('prod_nummer').'</strong> wurde angelegt!');

        return view('admin.produkt.show', ['produkt' => $produkt]);
    }

    public function validateProduktKategorie(): array
    {
        return request()->validate([
            'pkp_label' => [
                'bail',
                'min:2',
                'max:20',
                'required',
            ],
            'pkp_name' => 'bail|string|max:100',
            'pkp_value' => '',
            'produkt_kategorie_id' => 'required',
        ]);
    }

    public function updateProduktAnforderung(Request $request)
    {
        dd($request);
    }

    /**
     *  Löscht die Zuordnung der Anforderung vom Produkt
     *
     *
     * @return RedirectResponse
     */
    public function deleteProduktAnfordrung(Request $request)
    {

        $anforderung = Anforderung::find($request->anforderung_id);

        $euipUdate = '';

        if (! ProduktAnforderung::find($request->id)) {
            return redirect()->back();
        }

        foreach (Equipment::where('produkt_id', $request->produkt_id)->get() as $equipment) {

            if (ControlEquipment::where('anforderung_id', $request->anforderung_id)->where('equipment_id', $equipment->id)->count() > 0) {

                ControlEquipment::where('anforderung_id', $request->anforderung_id)->where('equipment_id', $equipment->id)->delete();

                $equipHistory = new EquipmentHistory;
                $equipHistory->eqh_eintrag_kurz = 'Anforderung gelöscht';
                $equipHistory->eqh_eintrag_text = 'Die Anforderung '.$anforderung->an_name.' wurde dem Produkt entfernt. Die Prüfungstabelle der abhängigen Geräten wurde aktualisiert.';
                $equipHistory->equipment_id = $equipment->id;
                $equipHistory->save();
                $updEquip = Equipment::where('produkt_id', request('produkt_id'))->count();

                if ($updEquip > 1) {
                    $euipUdate = '<br>'.$updEquip.' Geräte wurden aktualisiert';
                } elseif ($updEquip == 1) {
                    $euipUdate = '<br>'.$updEquip.' Gerät wurde aktualisiert';
                }
            }
        }

        if (ProduktAnforderung::find($request->id)->delete()) {
            $request->session()->flash('status', 'Die Anforderung  <strong>'.request('an_label').'</strong> wurde vom Produkt entfernt!'.$euipUdate);

            return redirect()->back();
        } else {
            dd('nix da');
        }

    }

    public function addProduktAnforderung(Request $request)
    {

        ProduktAnforderung::create($this->validateProduktAnforderung());

        $anforderung = Anforderung::find($request->anforderung_id);
        $euipUdate = '';

        $interval = $anforderung->an_control_interval;
        $dateSting = $anforderung->ControlInterval->ci_delta;

        foreach (Equipment::where('produkt_id', request('produkt_id'))->get() as $equipment) {

            if (ControlEquipment::where('anforderung_id', $request->anforderung_id)->where('equipment_id', $equipment->id)->count() === 0) {
                $equipControlItem = new ControlEquipment;
                $equipControlItem->qe_control_date_last = now();
                $equipControlItem->qe_control_date_due = now()->add('P'.$interval.$dateSting[0]);
                $equipControlItem->qe_control_date_warn = 4;
                $equipControlItem->anforderung_id = $request->anforderung_id;
                $equipControlItem->equipment_id = $equipment->id;
                $equipControlItem->save();

                $equipHistory = new EquipmentHistory;
                $equipHistory->eqh_eintrag_kurz = 'Neue Anforderung erhalten';
                $equipHistory->eqh_eintrag_text = 'Die Anforderung '.$anforderung->an_name.' wurde dem Produkt angefügt. Die Prüfungstabelle der abhängigen Geräten wurde aktualisiert.';
                $equipHistory->equipment_id = $equipment->id;
                $equipHistory->save();
                $updEquip = Equipment::where('produkt_id', request('produkt_id'))->count();

                if ($updEquip > 1) {
                    $euipUdate = '<br>'.$updEquip.' Geräte wurden aktualisiert';
                } elseif ($updEquip == 1) {
                    $euipUdate = '<br>'.$updEquip.' Gerät wurde aktualisiert';
                }
            }
        }
        $request->session()->flash('status', 'Die Anforderung wurde erfolgreich  <strong>'.request('an_label').'</strong> verknüpft!'.$euipUdate);

        return redirect()->back();
    }

    public function validateProduktAnforderung(): array
    {
        return request()->validate([
            'produkt_id' => 'required',
            'anforderung_id' => 'required|gt:0',
        ]);
    }

    public function addQualifiedUser(Request $request)
    {
        dd($request);
    }
}
