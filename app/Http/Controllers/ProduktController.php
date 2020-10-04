<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Contact;
use App\Firma;
use App\FirmaProdukt;
use App\ProduktAnforderung;
use App\ProduktKategorie;
use App\Produkt;
use App\ProduktKategorieParam;
use App\ProduktParam;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use function Symfony\Component\VarDumper\Dumper\esc;

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
        $produktList = Produkt::with('ProduktKategorie','ProduktState')->paginate(15);
        return view('admin.produkt.index',['produktList'=>$produktList]);
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

        return view('admin.produkt.import');
    }

    /**
     * Führt zur Exportseite für Produkte
     *
     * @return Application|Factory|Response|View
     */
    public function exportProdukt()
    {

        return view('admin.produkt.export');
    }

    /**
     * Display the specified resource.
     * @param Produkt $produkt
     * @return Application|Factory|Response|View
     */
    public function show(Produkt $produkt)
    {
        return view('admin.produkt.show', ['produkt' => $produkt]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Produkt $produkt
     * @param ProduktParam ProduktParam
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Produkt $produkt)
    {
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
     * Speichere neuen Produktstamm
     *
     * @param Request $request
     * @return Application|Response
     */
    public function store(Request $request)
    {
        $produkt = Produkt::create($this->validateNewProdukt());

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
        $request->session()->flash('status', 'Das Produkt <strong>' . request('prod_nummer') . '</strong> wurde angelegt!');
        return redirect($produkt->path());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy(Request $request)
    {
        Produkt::find($request->produkt_id)->delete();
        $request->session()->flash('status', 'Das Produkt wurde gelöscht!');
        return redirect(route('produkt.index'));
    }

    public function addProduktFirma(Request $request) {

        $address_id = false;
        $firma_id = false;

        $st = [];

        $st['request'] = $request;

        if (isset($request->ckAddNewAddress)){
            $addresse =  Adresse::create($this->validateAdresse());
            $address_id = $addresse->id;
            $st['add'][] = 'Neue Adresse anlegen';
//            $address_id = 12;
        }

        if (isset($request->ckAddNewFirma)){
            $st['firma'][] = 'Neue Firma anlegen';
//            $firma_id = 59;
            if ($address_id!==false) {
                $st['firma'][] = '$address_id -> ' . $address_id;
                $valdateFirma = $this->validateFirma();
                $fa = new Firma();
                $fa->fa_name_kurz = $request->fa_name_kurz;
                $fa->fa_name_lang = $request->fa_name_lang;
                $fa->fa_kreditor_nr = $request->fa_kreditor_nr;
                $fa->fa_debitor_nr = $request->fa_debitor_nr;
                $fa->fa_vat = $request->fa_vat;
                $fa->adresse_id = $address_id;
                $fa->save();
                $firma_id = $fa->id;

            } else{
                $st['firma'][] = '$address_id wird übernommen ->'.$request->adress_id;
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

        if (isset($request->ckAddNewContact)){
            if ($firma_id) {
                $st['contact'] = 'Baue neuen Kontakt mit neuer Firma';
                $valContact =  $this->validateContact();

                $con = new Contact();

                $con->con_name_kurz = $request->con_name_kurz;
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

        $request->session()->flash('status', 'Das Produkt wurde der Firma '.$request->fa_name_lang.' zugeordnet!');

        return redirect()->back();

    }

    public function removeFirmaFromProdukt(Request $request) {

        $faprod = FirmaProdukt::where([
            ['produkt_id',request('produktid')],
            ['firma_id',request('firmaid')],
        ])->delete();

        $request->session()->flash('status', 'Die Firma wurde vom Produkt entfernt!');

        return redirect()->back();
    }

    public function validateFirmaProdukt() {
        return request()->validate([
            'firma_id' => 'required',
            'produkt_id' => 'required',
        ]);
    }

    public function validateAdresse() {
        return request()->validate([
            'ad_name_kurz' => 'bail|max:20|required|unique:adresses,ad_name_kurz',
            'ad_anschrift_strasse' => 'bail|required|max:100',
            'ad_anschrift_plz' => 'bail|required|max:100',
            'ad_anschrift_ort' => 'bail|required|max:100',
            'ad_anschrift_hausnummer' => 'max:100',
            'land_id' => 'max:100',
        ]);
    }

    public function validateFirma() {
        return request()->validate([
            'fa_name_kurz' => 'bail|max:20|required|unique:firmas,fa_name_kurz',
            'fa_name_lang' => 'max:100',
            'fa_kreditor_nr' => 'max:100',
            'fa_debitor_nr' => 'max:100',
            'fa_vat' => 'max:30',
            'adress_id' => '',
        ]);
    }

    public function validateContact() {
        return request()->validate([
            'con_name_kurz' => 'bail|max:20|required|unique:contacts,con_name_kurz',
            'con_vorname' => 'max:100',
            'con_name' => 'max:100',
            'con_telefon' => 'max:100',
            'con_email' => 'max:100',
            'anrede_id' => '',
        ]);
    }


    public function getKategorieProducts(Request $request)
    {
        dd($request);
        $prodList = Produkt::where('produkt_kategorie_id',$request->pk)->paginate(20);
        return view('admin.produkt.kategorie.index',['prodList'=>$prodList,'id'=>$request]);
    }


    public function getProduktIdListAll(Request $request) {
        return DB::table('produkts')->select(
            'produkts.id','prod_nummer','prod_name_lang','pk_name_kurz', 'prod_name_kurz'
        )->distinct()
            ->join('produkt_kategories', 'produkts.produkt_kategorie_id', '=', 'produkt_kategories.id')
            ->leftJoin('produkt_params', 'produkts.id', '=', 'produkt_params.produkt_id')
            ->where('prod_name_kurz','like', '%'.$request->term . '%')
            ->orWhere('prod_name_lang','like', '%'.$request->term . '%')
            ->orWhere('prod_name_text','like', '%'.$request->term . '%')
            ->orWhere('prod_nummer','like', '%'.$request->term . '%')
            ->orWhere('pp_name','like', '%'.$request->term . '%')
            ->orWhere('pp_label','like', '%'.$request->term . '%')
            ->get();

    }

    /**
     *
     *   Liefert die JSON-Daten für die Übersichtstablle in /produkt -> index.blade.php
     *
     * @param Request $request
     * @return array JSON
     */
    public function getProduktListe(Request $request)
    {
        $data = [];
        //        DB::connection()->enableQueryLog();
        $prduktCache = \Cache::remember('produkt-liste-kat-'.$request->id,now()->addSeconds(2), function () use($request){
            return Produkt::with('ProduktKategorie', 'ProduktState')->where('produkt_kategorie_id', $request->id)->get();
        });
        $produkts = $prduktCache;
        foreach ($produkts as $produkt) {
            $icon = ($produkt->prod_active === 1) ? '<i class="fas fa-check text-success"  data-toggle="tooltip" data-placement="top" ></i>' : '<i class="fas fa-times text-danger"  data-toggle="tooltip" data-placement="top"></i>';
            $data[] =
                [
                    'term' => $request->id,
                    'id' => $produkt->id,
                    'prod_kategorie' =>  $produkt->ProduktKategorie->pk_name_kurz,
                    'created_at' => date('d.m.Y H:s', strtotime($produkt->created_at)),
                    'prod_nummer' => $produkt->prod_nummer,
                    'prod_name_kurz' => $produkt->prod_name_kurz,
                    'prod_active' => $icon,
                    'prod_status' => '<i class="' . $produkt->ProduktState->ps_icon . ' text-' . $produkt->ProduktState->ps_color . '"  data-toggle="tooltip" data-placement="top" title="' . $produkt->ProduktState->ps_name_lang . '"></i>',
                    'prod_link' => '<a href="/produkt/' . $produkt->id . '" class="btn btn-outline-secondary btn-sm"><i class="fas fa-angle-right"></i></a>'
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
     * @param ProduktKategorieParam $produktKategorieParam
     * @param Request $request
     * @return bool
     */
    public function updateProduktKategorieParams(ProduktKategorieParam $produktKategorieParam, Request $request)
    {

        $val = $this->validateProduktKategorieParam();

        $param = ProduktKategorieParam::find($request->id);

        $param->pkp_label = $request->pkp_label;
        $param->pkp_value = $request->pkp_value;
        return  $param->save();

        //      $produktKategorieParam->update($this->validateProduktKategorieParam());


    }

    /**
     * Speichere neuen Produktstamm
     *
     * @param Request $request
     * @return Application|Response
     */
    public function addProduktKategorieParam(Request $request)
    {
        $pkp = ProduktKategorieParam::create($this->validateNewProduktKategorieParam());
        $request->session()->flash('status', 'Das Datenfeld <strong>' . request('pkp_name') . '</strong> wurde angelegt!');
        return view('admin.systems');
    }

    /**
     *  Löscht den Param von der Produk-Kategorie
     *
     * @param Request $request
     * @return Application|Response
     */
    public function deleteProduktKategorieParam(Request $request)
    {

        ProduktKategorieParam::find($request->id)->delete();

        $request->session()->flash('status', 'Das Datenfeld  <strong>' . request('pkp_label') . '</strong> wurde gelöscht!');

        return redirect(route('systems'));
    }/**
 * Fügt neue Kategorie für Produktstamm hinzu
 *
 * @param Request $request
 * @return Application|Response
 */
    public function addProduktKategorie(Request $request)
    {
        $produkt = ProduktKategorie::create($this->validateNewProduktKategorie());
        $request->session()->flash('status', 'Die Produktkategorie  <strong>' . request('prod_nummer') . '</strong> wurde angelegt!');
        return view('admin.produkt.show', ['produkt' => $produkt]);
    }
    /**
     * Fügt neue Kategorie für Produktstamm hinzu
     *
     * @param Request $request
     * @return Application|Response
     */
    public function addProduktParams(Request $request)
    {
        ProduktParam::create($this->validateProduktParam());
        $request->session()->flash('status', 'Das Datenfeld  <strong>' . request('pp_name') . '</strong> wurde angelegt!');
        return redirect(route('produkt.show', ['produkt' => request('produkt_id')]));
    }

    /**
     *  Löscht die Zuordnung der Anforderung vom Produkt
     *
     * @param Request $request
     * @return Application|Response
     */
    public function deleteProduktAnfordrung(Request $request)
    {

        ProduktAnforderung::find($request->id)->delete();

        $request->session()->flash('status', 'Das Anforderung  <strong>' . request('an_name_kurz') . '</strong> wurde vom Produkt entfernt!');
        return redirect(route('produkt.show', ['produkt' => request('produkt_id')]));
    }

    public function addProduktAnforderung(Request $request)
    {
        ProduktAnforderung::create($this->validateNewProduktAnforderung());
        $request->session()->flash('status', 'Die Anforderung wurde erfolgreich  <strong>' . request('an_name_kurz') . '</strong> verknüpft!');
        return redirect(route('produkt.show', ['produkt' => request('produkt_id')]));
    }
    /**
     * @return array
     */
    public function validateNewProduktAnforderung(): array
    {
        return request()->validate([
            'produkt_id' => 'required',
            'anforderung_id' => 'required|gt:0'
        ]);
    }


    /**
     * @return array
     */
    public function validateProduktParam(): array
    {
        return request()->validate([
            'pp_label' => 'bail|unique:produkt_params,pp_label|max:20|required',
            'pp_value' => 'bail|max:150',
            'pp_name' => 'bail|string|max:150',
            'produkt_id' => 'required'
        ]);
    }

    /**
     *
     */
    public function updateParams($label, $pid, $value)
    {
    }


    /**
     * @return array
     */
    public function validateNewProdukt(): array
    {
        return request()->validate([
            'prod_name_kurz' => 'bail|unique:produkts,prod_name_kurz|min:2|max:20|required',
            'prod_name_lang' => 'max:100',
            'prod_name_text' => '',
            'prod_nummer' => 'bail|unique:produkts,prod_nummer|alpha_dash|max:100',
            'prod_active' => '',
            'produkt_kategorie_id' => '',
            'produkt_state_id' => 'required'
        ]);
    }


    /**
     * @return array
     */
    public function validateProdukt(): array
    {
        return request()->validate([
            'prod_name_kurz' => 'bail|min:2|max:20|required',
            'prod_name_lang' => 'max:100',
            'prod_name_text' => '',
            'prod_nummer' => 'bail|required|min:2|max:100',
            'prod_active' => '',
            'produkt_state_id' => 'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateNewProduktKategorie(): array
    {
        return request()->validate([
            'prod_name_kurz' => 'bail|unique:produkts,prod_name_kurz|min:2|max:20|required',
            'prod_name_lang' => 'bail|string|max:100',
            'prod_name_text' => '',
            'prod_nummer' => 'bail|unique:produkts,prod_nummer|required|min:2|max:100',
            'prod_active' => '',
            'produkt_state_id' => 'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateProduktKategorie(): array
    {
        return request()->validate([
            'prod_name_kurz' => 'bail|unique:produkts,prod_name_kurz|min:2|max:20|required',
            'prod_name_lang' => 'bail|string|max:100',
            'prod_name_text' => '',
            'prod_nummer' => 'bail|unique:produkts,prod_nummer|required|min:2|max:100',
            'prod_active' => '',
            'produkt_state_id' => 'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateNewProduktKategorieParam(): array
    {
        return request()->validate([
            'pkp_label' => 'bail|unique:produkts,prod_name_kurz|min:2|max:20|required',
            'pkp_name' => 'bail|string|max:100',
            'pkp_value' => '',
            'produkt_kategorie_id' => 'required'
        ]);
    }
    /**
     * @return array
     */
    public function validateProduktKategorieParam(): array
    {
        return request()->validate([
            'pkp_label' => 'bail|max:20|required',
            'pkp_name' => 'bail|string|max:150',
            'pkp_value' => 'bail|string|max:150',
            'produkt_kategorie_id' => 'required'
        ]);
    }
}
