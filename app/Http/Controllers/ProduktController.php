<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Anforderung;
use App\Contact;
use App\ControlEquipment;
use App\ControlProdukt;
use App\Equipment;
use App\EquipmentHistory;
use App\Firma;
use App\FirmaProdukt;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProduktController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Führt zur Übersichtsseite Produkt
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $produktList = Produkt::with('ProduktKategorie', 'ProduktState', 'ControlProdukt')->sortable()->paginate(10);
        return view('admin.produkt.index', compact('produktList'));
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
     * @param  Produkt $produkt
     *
     * @return Application|Factory|Response|View
     */
    public function show(Produkt $produkt)
    {
        foreach($produkt->ProduktDoc as $produktDoc){
            if(Storage::disk('local')->missing(($produktDoc->proddoc_name_pfad)))
 //          dump('Keine Datei ' . $produktDoc->proddoc_name_pfad);
           $produktDoc->delete();
        }



        return view('admin.produkt.show', [
            'produkt'    => $produkt,
            'equipLists' => Equipment::where('produkt_id', $produkt->id)->with('EquipmentState', 'produktDetails')->sortable()->paginate(10)
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Produkt $produkt
     * @param  ProduktParam ProduktParam
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Produkt $produkt)
    {

//        dd($request);

//        $this->authorize('isAdmin', Auth()->user());
        if (isset($request->control_product)) {
            ControlProdukt::updateOrInsert(['produkt_id' => $request->id]);
        }

        $produkt->prod_active = $request->has('prod_active') ? 1 : 0;


        $produkt->update($this->validateProdukt());

        //        dd(isset($request->pp_label));
        if (isset($request->pp_label) && count($request->pp_label) > 0) {
            for ($i = 0; $i < count($request->pp_label); $i++) {
                $param = ProduktParam::find($request->pp_id[$i]);
                $param->pp_value = $request->pp_label[$i];
                $param->save();
            }
        }


        $request->session()->flash('status', 'Das Produkt <strong>' . $produkt->prod_nummer . '</strong> wurde aktualisiert!');
        return redirect($produkt->path());
    }

    /**
     * @return array
     */
    public function validateProdukt()
    : array
    {
        return request()->validate([
            'prod_label'           => [
                'bail',
                'min:2',
                'max:20',
                'required',
                Rule::unique('produkts')->ignore(\request('id'))
            ],
            'prod_name'            => '',
            'prod_description'     => '',
            'prod_nummer'          => [
                'bail',
                'alpha_dash',
                'max:100',
                Rule::unique('produkts')->ignore(\request('id'))
            ],
            'prod_active'          => '',
            'produkt_kategorie_id' => 'nullable',
            'produkt_state_id'     => 'required'
        ]);
    }

    /**
     * Speichere neuen Produktstamm
     *
     * @param  Request $request
     *
     * @return Application|Response
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
//        $this->authorize('isAdmin', Auth()->user());

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
            $controlProduct = new ControlProdukt();
            $controlProduct->produkt_id = $produkt->id;
            $controlProduct->save();
        }

        $request->session()->flash('status', __('Das Produkt <strong>:label</strong> wurde angelegt!', ['label' => request('prod_nummer')]));
        return redirect($produkt->path());
    }

    public function ajaxstore(Request $request)
    {

        if (isset($request->produkt_kategorie_id) && $request->produkt_kategorie_id === 'new') {
            $prodKat = new ProduktKategorie();
            $prodKat->pk_label = $request->newProduktKategorie;
            $prodKat->save();
            $produkt_kategorie_id = $prodKat->id;
        } else {
            $produkt_kategorie_id = $request->produkt_kategorie_id;
        }
        $this->validateProdukt();
        $produkt = new Produkt();
        $produkt->prod_label = $request->prod_label;
        $produkt->prod_name = $request->prod_name;
        $produkt->produkt_state_id = $request->produkt_state_id;
        $produkt->prod_active = $request->prod_active;
        $produkt->prod_nummer = $request->prod_nummer;
        $produkt->prod_description = $request->prod_description;
        $produkt->produkt_kategorie_id = $produkt_kategorie_id;
        $produkt->save();


        if (request()->has('control_product')) {
            $controlProduct = new ControlProdukt();
            $controlProduct->produkt_id = $produkt->id;
            $controlProduct->save();
        }
        $produkt_id = $produkt->id;

        if (isset($request->anforderung_id)) {
            for ($i = 0; $i < count($request->anforderung_id); $i++) {
                $prodAnfor = new ProduktAnforderung();
                $prodAnfor->produkt_id = $produkt_id;
                $prodAnfor->anforderung_id = $request->anforderung_id[$i];
                $prodAnfor->save();
            }
        }

        if ($request->hasFile('prodDokumentFile')) {

            $proDocFile = new ProduktDoc();
            $file = $request->file('prodDokumentFile');
            $this->validateProduktDokument();
            $request->validate([
                'prodDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg,gif,svg'
                // size:2048 => 2048kB
            ]);

            $proDocFile->proddoc_name = $file->getClientOriginalName();
            $proDocFile->proddoc_name_pfad = $file->store('produkt_docu/' . $produkt_id);
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->produkt_id = $produkt_id;
            $proDocFile->proddoc_description = request('proddoc_description');
            $proDocFile->proddoc_label = request('proddoc_label');
            $proDocFile->save();
        }

        return redirect()->route('equipment.create', ['produkt_id' => $produkt->id]);
    }

    /**
     * @return array
     */
    public function validateProduktDokument()
    : array
    {
        return request()->validate([
            'proddoc_label'       => 'bail|required|max:150',
            'proddoc_name'        => 'max:100',
            'proddoc_name_pfad'   => 'max:150',
            'document_type_id'    => 'required',
            'proddoc_description' => ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function destroy(Request $request)
    {
//        $this->authorize('isAdmin', Auth()->user());
        Produkt::find($request->produkt_id)->delete();
        $request->session()->flash('status', __('Das Produkt wurde gelöscht!'));
        return redirect(route('produkt.index'));
    }

    public function addProduktFirma(Request $request)
    {

        $address_id = false;
        $firma_id = false;

        $st = [];

        $st['request'] = $request;

        if (isset($request->ckAddNewAddress)) {

            $this->validateAdresse();
            $addresse = new Adresse();
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
                $st['firma'][] = '$address_id -> ' . $address_id;
                $this->validateFirma();
                $fa = new Firma();
                $fa->fa_label = $request->fa_label;
                $fa->fa_name = $request->fa_name;
                $fa->fa_kreditor_nr = $request->fa_kreditor_nr;
                $fa->fa_debitor_nr = $request->fa_debitor_nr;
                $fa->fa_vat = $request->fa_vat;
                $fa->adresse_id = $address_id;
                $fa->save();
                $firma_id = $fa->id;
            } else {
                $st['firma'][] = '$address_id wird übernommen ->' . $request->adress_id;
                $firma = Firma::create($this->validateFirma());
                $firma_id = $firma->id;
            }

            $st['FirmaProdukt'][] = 'Baue neues FirmaProdukt aus neuer Firma';
            $faprod = new FirmaProdukt();
            $faprod->firma_id = $firma_id;
            $faprod->produkt_id = $request->produkt_id;
            $faprod->save();
        } else {
            $st['FirmaProdukt'][] = 'Baue neue FirmaProdukt aus bestehender Firma';
            FirmaProdukt::create($this->validateFirmaProdukt());
        }

        if (isset($request->ckAddNewContact)) {
            if ($firma_id) {
                $st['contact'] = 'Baue neuen Kontakt mit neuer Firma';
                $this->validateContact();

                $con = new Contact();

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

        $request->session()->flash('status', 'Das Produkt wurde der Firma ' . $request->fa_name . ' zugeordnet!');

        return redirect()->back();
    }

    public function validateAdresse()
    : array
    {
        return request()->validate([
            'ad_label'                => 'bail|max:20|required|unique:adresses,ad_label',
            'ad_anschrift_strasse'    => 'bail|required|max:100',
            'ad_anschrift_plz'        => 'bail|required|max:100',
            'ad_anschrift_ort'        => 'bail|required|max:100',
            'ad_anschrift_hausnummer' => 'max:100',
            'land_id'                 => 'max:100',
            'address_type_id'         => '',
        ]);
    }

    public function validateFirma()
    : array
    {
        return request()->validate([
            'fa_label'       => 'bail|max:20|required|unique:firmas,fa_label',
            'fa_name'        => 'max:100',
            'fa_kreditor_nr' => 'max:100',
            'fa_debitor_nr'  => 'max:100',
            'fa_vat'         => 'max:30',
            'adress_id'      => '',
        ]);
    }

    public function validateFirmaProdukt()
    : array
    {
        return request()->validate([
            'firma_id'   => 'required',
            'produkt_id' => 'required',
        ]);
    }

    public function validateContact()
    : array
    {
        return request()->validate([
            'con_label'   => 'bail|max:20|required|unique:contacts,con_label',
            'con_vorname' => 'max:100',
            'con_name'    => 'max:100',
            'con_telefon' => 'max:100',
            'con_email'   => 'max:100',
            'anrede_id'   => '',
        ]);
    }

    public function removeFirmaFromProdukt(Request $request)
    {
//        $this->authorize('isAdmin', Auth()->user());
        $faprod = FirmaProdukt::where([
            [
                'produkt_id',
                request('produktid')
            ],
            [
                'firma_id',
                request('firmaid')
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
            'id'       => $id
        ]);
    }

    public function getProduktIdListAll(Request $request)
    {
        return DB::table('produkts')->select('produkts.id', 'prod_nummer', 'prod_name', 'pk_label', 'prod_label')->distinct()->join('produkt_kategories', 'produkts.produkt_kategorie_id', '=', 'produkt_kategories.id')->leftJoin('produkt_params', 'produkts.id', '=', 'produkt_params.produkt_id')->where('prod_label', 'like', '%' . $request->term . '%')->orWhere('prod_name', 'like', '%' . $request->term . '%')->orWhere('prod_description', 'like', '%' . $request->term . '%')->orWhere('prod_nummer', 'like', '%' . $request->term . '%')->orWhere('pp_name', 'like', '%' . $request->term . '%')->orWhere('pp_label', 'like', '%' . $request->term . '%')->get();
    }

    /**
     *   Liefert die JSON-Daten für die Übersichtstablle in /produkt -> index.blade.php
     *
     * @param  Request $request
     *
     * @return array JSON
     */
    public function getProduktListe(Request $request)
    {
        $data = [];
        //        DB::connection()->enableQueryLog();
        $prduktCache = Cache::remember('produkt-liste-kat-' . $request->id, now()->addSeconds(2), function () use ($request) {
            return Produkt::with('ProduktKategorie', 'ProduktState')->where('produkt_kategorie_id', $request->id)->get();
        });
        $produkts = $prduktCache;
        foreach ($produkts as $produkt) {
            $icon = ($produkt->prod_active === 1) ? '<i class="fas fa-check text-success"  data-toggle="tooltip" data-placement="top" ></i>' : '<i class="fas fa-times text-danger"  data-toggle="tooltip" data-placement="top"></i>';
            $data[] = [
                'term'           => $request->id,
                'id'             => $produkt->id,
                'prod_kategorie' => $produkt->ProduktKategorie->pk_label,
                'created_at'     => date('d.m.Y H:s', strtotime($produkt->created_at)),
                'prod_nummer'    => $produkt->prod_nummer,
                'prod_label'     => $produkt->prod_label,
                'prod_active'    => $icon,
                'prod_status'    => '<i class="' . $produkt->ProduktState->ps_icon . ' text-' . $produkt->ProduktState->ps_color . '"  data-toggle="tooltip" data-placement="top" title="' . $produkt->ProduktState->ps_name . '"></i>',
                'prod_link'      => '<a href="/produkt/' . $produkt->id . '" class="btn btn-outline-secondary btn-sm"><i class="fas fa-angle-right"></i></a>'
            ];
        }
        //        dd(DB::getQueryLog());
        return $data;
    }

    public function getProduktKategorieParams(ProduktKategorieParam $produktKategorieParam, Request $request)
    {
        return ProduktKategorieParam::where('produkt_kategorie_id', $request->id)->get();
    }

    public function getUsedProduktsByPK(Request $request)
    {
        return Produkt::where('produkt_kategorie_id', $request->id)->count();
    }

    /**
     * @param  ProduktKategorieParam $produktKategorieParam
     * @param  Request               $request
     *
     * @return bool
     */
    public function updateProduktKategorieParams(ProduktKategorieParam $produktKategorieParam, Request $request)
    {

        $this->validateProduktKategorieParam();

        $param = ProduktKategorieParam::find($request->id);

        $param->pkp_label = $request->pkp_label;
        $param->pkp_value = $request->pkp_value;
        return $param->save();

        //      $produktKategorieParam->update($this->validateProduktKategorieParam());


    }

    /**
     * @return array
     */
    public function validateProduktKategorieParam()
    : array
    {
        return request()->validate([
            'pkp_label'            => [
                'bail',
                'unique:produkts,prod_label',
                'min:2',
                'max:20',
                'required'
            ],
            'pkp_name'             => 'bail|string|max:100',
            'pkp_value'            => '',
            'produkt_kategorie_id' => 'required'
        ]);
    }

    /**
     * Speichere neuen Produktstamm
     *
     * @param  Request $request
     *
     * @return Application|Response
     * @throws AuthorizationException
     */
    public function addProduktKategorieParam(Request $request)
    {
//        $this->authorize('isAdmin', Auth()->user());
        ProduktKategorieParam::create($this->validateProduktKategorieParam());
        $request->session()->flash('status', __('Das Datenfeld <strong>:label</strong> wurde angelegt!', ['label' => request('pkp_name')]));
        return view('admin.systems');
    }

    /**
     *  Löscht den Param von der Produk-Kategorie
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function deleteProduktKategorieParam(Request $request)
    {
//        $this->authorize('isAdmin', Auth()->user());
        ProduktKategorieParam::find($request->id)->delete();
        $request->session()->flash('status', __('Das Datenfeld <strong>:label</strong> wurde gelöscht!', ['label' => request('pkp_name')]));
        return back();
    }

    /**
     * Fügt neue Kategorie für Produktstamm hinzu
     *
     * @param  Request $request
     *
     * @return Application|Response
     */
    public function addProduktKategorie(Request $request)
    {
        $produkt = ProduktKategorie::create($this->validateProduktKategorie());
        $request->session()->flash('status', 'Die Produktkategorie  <strong>' . request('prod_nummer') . '</strong> wurde angelegt!');
        return view('admin.produkt.show', ['produkt' => $produkt]);
    }

    /**
     * @return array
     */
    public function validateProduktKategorie()
    : array
    {
        return request()->validate([
            'pkp_label'            => [
                'bail',
                'unique:produkts,prod_label',
                'min:2',
                'max:20',
                'required'
            ],
            'pkp_name'             => 'bail|string|max:100',
            'pkp_value'            => '',
            'produkt_kategorie_id' => 'required'
        ]);
    }

    /**
     * Fügt neue Kategorie für Produktstamm hinzu
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function addProduktParams(Request $request)
    {
        ProduktParam::create($this->validateProduktParam());
        $request->session()->flash('status', 'Das Datenfeld  <strong>' . request('pp_name') . '</strong> wurde angelegt!');
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateProduktParam()
    : array
    {
        return request()->validate([
            'pp_label'   => 'bail|unique:produkt_params,pp_label|max:20|required',
            'pp_value'   => 'bail|max:150',
            'pp_name'    => 'bail|string|max:150',
            'produkt_id' => 'required'
        ]);
    }

    /**
     *  Löscht die Zuordnung der Anforderung vom Produkt
     *
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function deleteProduktAnfordrung(Request $request)
    {

        $anforderung = Anforderung::find($request->anforderung_id);
        $euipUdate = '';

        if (!ProduktAnforderung::find($request->id)){
            return redirect()->back();
        }


            foreach (Equipment::where('produkt_id', ProduktAnforderung::find($request->id)->produkt_id)->get() as $equipment) {

            if (ControlEquipment::where('anforderung_id', $request->anforderung_id)->where('equipment_id', $equipment->id)->count() > 0) {
                ControlEquipment::where('anforderung_id', $request->anforderung_id)->where('equipment_id', $equipment->id)->delete();

                $equipHistory = new EquipmentHistory();
                $equipHistory->eqh_eintrag_kurz = 'Anforderung gelöscht';
                $equipHistory->eqh_eintrag_text = 'Die Anforderung ' . $anforderung->an_name . ' wurde dem Produkt entfernt. Die Prüfungstabelle der abhängigen Geräten wurde aktualisiert.';
                $equipHistory->equipment_id = $equipment->id;
                $equipHistory->save();
                $updEquip = Equipment::where('produkt_id', request('produkt_id'))->count();

                if ($updEquip > 1) {
                    $euipUdate = '<br>' . $updEquip . ' Geräte wurden aktualisiert';
                } elseif ($updEquip == 1) {
                    $euipUdate = '<br>' . $updEquip . ' Gerät wurde aktualisiert';
                }
            }
        }


        ProduktAnforderung::find($request->id)->delete();

        $request->session()->flash('status', 'Das Anforderung  <strong>' . request('an_label') . '</strong> wurde vom Produkt entfernt!' . $euipUdate);
        return redirect()->back();
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
                $equipControlItem = new ControlEquipment();
                $equipControlItem->qe_control_date_last = now();
                $equipControlItem->qe_control_date_due = now()->add('P' . $interval . $dateSting[0]);
                $equipControlItem->qe_control_date_warn = 4;
                $equipControlItem->anforderung_id = $request->anforderung_id;
                $equipControlItem->equipment_id = $equipment->id;
                $equipControlItem->save();


                $equipHistory = new EquipmentHistory();
                $equipHistory->eqh_eintrag_kurz = 'Neue Anforderung erhalten';
                $equipHistory->eqh_eintrag_text = 'Die Anforderung ' . $anforderung->an_name . ' wurde dem Produkt angefügt. Die Prüfungstabelle der abhängigen Geräten wurde aktualisiert.';
                $equipHistory->equipment_id = $equipment->id;
                $equipHistory->save();
                $updEquip = Equipment::where('produkt_id', request('produkt_id'))->count();

                if ($updEquip > 1) {
                    $euipUdate = '<br>' . $updEquip . ' Geräte wurden aktualisiert';
                } elseif ($updEquip == 1) {
                    $euipUdate = '<br>' . $updEquip . ' Gerät wurde aktualisiert';
                }
            }
        }
        $request->session()->flash('status', 'Die Anforderung wurde erfolgreich  <strong>' . request('an_label') . '</strong> verknüpft!' . $euipUdate);
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateProduktAnforderung()
    : array
    {
        return request()->validate([
            'produkt_id'     => 'required',
            'anforderung_id' => 'required|gt:0'
        ]);
    }


    /**
     *
     */
    public function updateParams($label, $pid, $value)
    {

    }
}
