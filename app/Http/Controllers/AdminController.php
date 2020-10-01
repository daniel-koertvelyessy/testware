<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddressType;
use App\Admin;
use App\Anforderung;
use App\AnforderungControlItem;
use App\AnforderungType;
use App\Building;
//use App\BuildingType;
use App\BuildingTypes;
use App\DocumentType;
use App\Verordnung;
use App\ProduktKategorie;
use App\Produkt;
use App\Room;
use App\RoomType;
use App\Stellplatz;
use App\StellplatzTyp;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
        return view('admin.index');
    }

    public function systems()
    {
        return view('admin.systems');
    }

    public function indexUser()
    {
        return view('admin.user.index');
    }

    public function indexReports()
    {
        return view('admin.reports.index');
    }

    public function indexReportsTemplate()
    {
        return view('admin.reports.template');
    }

    public function registerphone()
    {
        return view('admin.registerphone');
    }

    /**
     *  Aktualisiert die CSS-Datei zur Darstellung von Farben und Schriften
     *
     * @param Request $request
     * @param User $adt
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateUserTheme(Request $request, User $adt)
    {
        $data = User::find($request->id);
        $data->user_theme = $request->systemTheme;
        $data->save();
        // $data->update($request->systemTheme);

        $request->session()->flash('status', 'Das Theme wurde aktualisiert!');
        return redirect(route('systems'));
    }


    /**
     * Speichert einen neuen Adresstyp
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createAddressType(Request $request)
    {
        AddressType::create($this->validateAdressTypes());

        $request->session()->flash('status', 'Der Adresstyp ' . request('adt_name') . ' wurde angelegt!');
        return redirect(route('systems'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AddressType $adt
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateAddressType(Request $request, AddressType $adt)
    {
        $data = AddressType::find($request->id);
        $data->update($this->validateAdressTypes());
        $request->session()->flash('status', 'Der Adresstyp <strong>' . $data->adt_name . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $id
     * @return Response
     */
    public function getAddressTypeData(Request $id)
    {
        $data = AddressType::find($id);
        return $data;
    }

    /**
     * @param Request $request
     * @param AddressType $adt
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteTypeAdress(Request $request, AddressType $adt)
    {

//        dd(, $adt->id);

        AddressType::destroy($request->id);
        $request->session()->flash('status', 'Der Adresstyp wurde gelöscht!');
        return redirect(route('systems'));

    }


    /**
     *
     *   ENDE   A D R E S S   T Y P E S
     *
     */





    /**
     * Speichere einen neuen Gebäudetyp.
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createBuildingType(Request $request)
    {
        BuildingTypes::create($this->validateNewBuldingTypes());

        $request->session()->flash('status', 'Der Gebäudetyp <strong>' . request('btname') . '</strong> wurde angelegt!');
        return (isset($request->frmOrigin) && $request->frmOrigin === 'location') ?  redirect('location/'.$request->location_id.'#locGebauede') :  redirect(route('systems'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BuildingTypes $adt
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateBuildingType(Request $request, BuildingTypes $adt)
    {
        $data = BuildingTypes::find($request->id);
        $data->update($this->validateBuldingTypes());

        $request->session()->flash('status', 'Der Gebäudetyp <strong>' . request('btname') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *
     * @param Request $id
     * @return Response
     */
    public function getBuildingTypeData(Request $id)
    {
        $data = BuildingTypes::find($id);
        return $data;
        // return response()->json($data);
    }

    /**
     * Ende Building types
     */


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createRoomType(Request $request)
    {

       $rt =  RoomType::create($this->validateNewRoomTypes());

        $request->session()->flash('status', 'Der Gebäudetyp <strong>' . request('rt_name_kurz') . '</strong> wurde angelegt!');
        return (isset($request->frmOrigin) && $request->frmOrigin === 'building')
            ?
            redirect(route('building.show',$request->location_id))
            :
            redirect(route('systems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param RoomType $rmt
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateRoomType(Request $request, RoomType $rmt)
    {
        $data = RoomType::findOrFail($request->id);
        $data->update($this->validateRoomTypes());
        $request->session()->flash('status', 'Der Raumtyp <strong>' . request('rt_name_kurz') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *
     * @param Request $id
     * @return Response
     */
    public function getRoomTypeData(Request $id)
    {
        $data = RoomType::findOrFail($id->id);
        return $data;
        // return response()->json($data);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteRoomType(Request $request )
    {
        RoomType::destroy($request->id);
        $request->session()->flash('status', 'Der Raumtyp wurde gelöscht!');
        return redirect(route('systems'));

    }



    /*
     *
     *
     *
     *
     *
     *
     *    S T E L L  P L Ä T Z E
     *
     *
     *             |
     *             |
     *           \ | /
     *             °
     *
     *
     */


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @return Response
     */
    public function createStellPlatzType(Request $request)
    {
        StellplatzTyp::create($this->validateNewStellPlatzTypes());

        $request->session()->flash('status', 'Der Stellplatztyp <strong>' . request('spt_name_kurz') . '</strong> wurde angelegt!');

        return (isset($request->frmOrigin) && $request->frmOrigin === 'room')
            ?
            redirect(route('room.show',$request->room_id))
            :
            redirect(route('systems'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\StellplatzTyp $StellPlatzTyp
     * @return Response
     */
    public function updateStellPlatzType(Request $request, StellplatzTyp $StellPlatzTyp)
    {
        $data = StellplatzTyp::findOrFail($request->id);
        $data->update($this->validateStellPlatzTypes());
        $request->session()->flash('status', 'Der Stellplatztyp <strong>' . request('spt_name_kurz') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * * @param Request $request
     * @return Response
     */
    public function getStellPlatzTypeData(Request $id)
    {
        $data = StellplatzTyp::findOrFail($id->id);
        return $data;
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteStellPlatzType(Request $request )
    {
        StellplatzTyp::destroy($request->id);
        $request->session()->flash('status', 'Der Stellplatztyp wurde gelöscht!');
        return redirect(route('systems'));

    }



    /*
     *
     *
     *
     *
     *
     *
     *    P R O D U K T  _ K A T E G O R I E N
     *
     *
     *             |
     *             |
     *           \ | /
     *             °
     *
     *
     */


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createProdKat(Request $request)
    {
        ProduktKategorie::create($this->validateProduktKategorie());

        $request->session()->flash('status', 'Die Prdukt-Kategorie <strong>' . request('pk_name_kurz') . '</strong> wurde angelegt!');
        return redirect(route('systems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ProduktKategorie $produktKategorie
     * @return Response
     */
    public function updateProdKat(Request $request, ProduktKategorie $produktKategorie)
    {
        $data = ProduktKategorie::findOrFail($request->id);
        $data->update($this->validateProduktKategorie());
        $request->session()->flash('status', 'Die Produkt-Kategorie <strong>' . request('pk_name_kurz') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * * @param Request $request
     * @return Response
     */
    public function getProdKatData(Request $id)
    {
        $data = ProduktKategorie::findOrFail($id->id);
        return $data;
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteProdKat(Request $request )
    {
        ProduktKategorie::destroy($request->id);
        $request->session()->flash('status', 'Die Produkt-Kategorie wurde gelöscht!');
        return redirect(route('systems'));

    }

    /*
        *
        *
        *
        *
        *
        *
        *    V E R O R D N U N G E N
        *
        *
        *             |
        *             |
        *           \ | /
        *             °
        *
        *
        */


    /**
     *  Speichere neue Anforderung
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createVerordnung(Request $request)
    {
        Verordnung::create($this->validateNewVerordnug());

        $request->session()->flash('status', 'Die Verordnung <strong>' . request('vo_name_kurz') . '</strong> wurde angelegt!');
        return redirect(route('systems'));
    }

    /**
     * Aktualisiere die gegebene Verordnung
     *
     * @param Request $request
     * @param Verordnung $anforderung
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateVerordnung(Request $request, Verordnung $anforderung)
    {
        $data = Verordnung::findOrFail($request->id);
        $data->update($this->validateVerordnug());
        $request->session()->flash('status', 'Die Verordnung <strong>' . request('vo_name_kurz') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *
     * @param Request $id
     * @return Response
     */
    public function getVerordnungData(Request $id)
    {
        return Verordnung::findOrFail($id->id);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteVerordnung(Request $request )
    {
        Verordnung::destroy($request->id);
        $request->session()->flash('status', 'Die Die Verordnung wurde gelöscht!');
        return redirect(route('systems'));

    }





    /*
        *
        *
        *
        *
        *
        *
        *    A N F O R D E R U N G E N
        *
        *
        *             |
        *             |
        *           \ | /
        *             °
        *
        *
        */


    /**
     *  Speichere neue Anforderung
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createAnforderung(Request $request)
    {
        Anforderung::create($this->validateAnforderung());

        $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_name_kurz') . '</strong> wurde angelegt!');
        return redirect(route('systems'));
    }

    /**
     * Aktualisiere die gegebene Anforderung
     *
     * @param Request $request
     * @param Anforderung $anforderung
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateAnforderung(Request $request, Anforderung $anforderung)
    {
        $data = Anforderung::findOrFail($request->id);
        $data->update($this->validateAnforderung());
        $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_name_kurz') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     * *
     *
     * @param Request $id
     * @return Builder|Builder[]|Collection|Model|Response
     */
    public function getAnforderungData(Request $id)
    {
        return Anforderung::with('verordnung')->findOrFail($id->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * *
    @* param Request $id
    @* return string

    public function getAnforderungByVerordnungListe(Request $request)
    {
        $data['id'] = $request->id;
        $data['html']='<option>bitte Anordnung wählen</option>';
        foreach (Anforderung::where('verordnung_id',$request->id)->get() as $anf){
            $data['html'].='
            <option value="'.$anf->id.'"
                    data-textlang="'.$anf->an_name_lang.'"
            >'.$anf->an_name_kurz.'</option>
            ';

        }
        return $data;
    }
*/


    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteAnforderung(Request $request )
    {
        Anforderung::destroy($request->id);
        $request->session()->flash('status', 'Die Die Anforderung wurde gelöscht!');
        return redirect(route('systems'));

    }


    /**
     *  Speichere neue Anforderung
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function addNewAnforderungControlItem(Request $request)
    {

        $request->firma_id = ($request->aci_exinternal === 'internal') ? 1 : $request->firma_id;


        AnforderungControlItem::create($this->validateNewAnforderungControlItem());

        $request->session()->flash('status', 'Der Vorgang <strong>' . request('aci_name_kurz') . '</strong> wurde angelegt!');
        return redirect(route('systems'));
    }

    public function updateAnforderungControlItem(Request $request) {

//        dd($request->id);
        $data = AnforderungControlItem::findOrFail($request->id);
        $data->update($this->validateAnforderungControlItem());
        $request->session()->flash('status', 'Der Vorgang <strong>' . request('aci_name_lang') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    public function getAnforderungControlItemData(Request $request) {
        return AnforderungControlItem::findorFail($request->id);
    }

    public function deleteAnforderungControlItem(Request $request)
    {

        AnforderungControlItem::destroy($request->id);
        $request->session()->flash('status', 'Der Vorgang wurde gelöscht!');
        return redirect(route('systems'));

    }

    public function addNewAnforderungType(Request $request) {
        AnforderungType::create($this->validateNewAnforderungType());
        $request->session()->flash('status', 'Der Prüfungstyp <strong>' . request('at_name_kurz') . '</strong> wurde angelegt!');
        return redirect(route('systems'));
    }
    public function updateAnforderungType(Request $request) {
        $data = AnforderungType::findOrFail($request->id);
        $data->update($this->validateAnforderungType());
        $request->session()->flash('status', 'Der Anforderung-Typ <strong>' . request('at_name_lang') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    public function getAnforderungTypData(Request $request) {
        return AnforderungType::findOrFail($request->id);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteAnforderungType(Request $request )
    {
        Anforderung::destroy($request->id);
        $request->session()->flash('status', 'Der Anforderung-Typ wurde gelöscht!');
        return redirect(route('systems'));

    }





    /*
        *
        *
        *
        *
        *
        *
        *    D O K U M E N T E N T Y P E N
        *
        *
        *             |
        *             |
        *           \ | /
        *             °
        *
        *
        */


    /**
     *  Speichere neue Dokzemententyp
     *
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createDokumentType(Request $request)
    {
        DocumentType::create($this->validateNewDokumentType());
        $request->session()->flash('status', 'Der Dokumententyp <strong>' . request('doctyp_name_kurz') . '</strong> wurde angelegt!');
        if (isset($request->origin)){
                if ($request->origin === 'produkt') return redirect('/produkt/'.$request->produkt_id.'#matDoku');
        } else {
            return redirect(route('systems'));
        }


    }

    /**
     * Aktualisiere die gegebene Dokzemententyp
     *
     * @param Request $request
     * @param DocumentType $documentype
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateDokumentType(Request $request, DocumentType $documentype)
    {
        $data = DocumentType::findOrFail($request->id);
        $data->update($this->validateDokumentType());
        $request->session()->flash('status', 'Der Dokumententyp <strong>' . request('doctyp_name_kurz') . '</strong> wurde aktualisiert!');
        return redirect(route('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *
     * @param Request $id
     * @return Response
     */
    public function getDokumentTypeData(Request $id)
    {
        return DocumentType::findOrFail($id->id);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteDokumentType(Request $request )
    {
        DocumentType::destroy($request->id);
        $request->session()->flash('status', 'Der Dokumententyp <strong>' . request('doctyp_name_kurz') . '</strong> wurde gelöscht!');
        return redirect(route('systems'));

    }

    /**
     * @return array
     */
    public function validateDokumentType(): array
    {
        return request()->validate([
            'doctyp_name_kurz' => 'bail|required|min:1|max:20',
            'doctyp_name_lang' => 'bail|min:1|max:100',
            'doctyp_name_text' => '',
            'doctyp_mandatory' => 'required'
        ]);
    }

    /**
     * @return array
     */
    public function validateNewDokumentType(): array
    {
        return request()->validate([
            'doctyp_name_kurz' => 'bail|required|unique:document_types,doctyp_name_kurz|min:1|max:20',
            'doctyp_name_lang' => 'bail|min:1|max:100',
            'doctyp_name_text' => '',
            'doctyp_mandatory' => 'required'
        ]);
    }



    /*
        *
        *
        *
        *
        *
        *
        *    V A L I D I E R U N G E N !
        *
        *
        *             |
        *             |
        *           \ | /
        *             °
        *
        *
        */

    /**
     * @return array
     */
    public function validateAdressTypes(): array
    {
        return request()->validate([
            'adt_name' => 'bail|required|min:1|max:20',
            'adt_text_lang' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateNewStellPlatzTypes(): array
    {
        return request()->validate([
            'spt_name_kurz' => 'bail|unique:stellplatz_typs,spt_name_kurz|required|min:1|max:20',
            'spt_name_lang' => 'max:100',
            'spt_name_text' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateStellPlatzTypes(): array
    {
        return request()->validate([
            'spt_name_kurz' => 'bail|required|min:1|max:20',
            'spt_name_lang' => 'max:100',
            'spt_name_text' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateBuldingTypes(): array
    {
        return request()->validate([
            'btname' => 'bail|required|min:1|max:20',
            'btbeschreibung' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateNewBuldingTypes(): array
    {
        return request()->validate([
            'btname' => 'bail|unique:building_types,btname|required|min:1|max:20',
            'btbeschreibung' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateNewRoomTypes(): array
    {
        return request()->validate([
            'rt_name_kurz' => 'bail|unique:room_types,rt_name_kurz|required|min:1|max:20',
            'rt_name_lang' => 'max:100',
            'rt_name_text' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateRoomTypes(): array
    {
        return request()->validate([
            'rt_name_kurz' => 'bail|required|min:1|max:20',
            'rt_name_lang' => 'max:100',
            'rt_name_text' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateProduktKategorie(): array
    {
        return request()->validate([
            'pk_name_kurz' => 'bail|required|min:1|max:20',
            'pk_name_lang' => 'bail|min:1|max:100',
            'pk_name_text' => ''
        ]);
    }

    /**
     * @return array
     */
    public function validateAnforderung(): array
    {
        return request()->validate([
            'an_name_kurz' => 'bail|required|max:20',
            'an_name_lang' => 'bail|max:100',
            'an_name_text' => '',
            'an_control_interval' => 'integer',
            'control_interval_id' => '',
            'verordnung_id' => '',
            'anforderung_type_id' => 'bail|required|integer',
        ]);
    }

    /**
     * @return array
     */
    public function validateNewAnforderungType(): array
    {
        return request()->validate([
            'at_name_kurz' => 'bail|required|unique:anforderung_types,at_name_kurz|max:20',
            'at_name_lang' => 'bail|max:100',
            'at_name_text' => '',
        ]);
    }

    /**
     * @return array
     */
    public function validateAnforderungType(): array
    {
        return request()->validate([
            'at_name_kurz' => 'bail|required|max:20',
            'at_name_lang' => 'bail|max:100',
            'at_name_text' => '',
        ]);
    }
    /**
     * @return array
     */
    public function validateVerordnug(): array
    {
        return request()->validate([
            'vo_name_kurz' => 'bail|required|min:1|max:20',
            'vo_name_lang' => 'bail|min:1|max:100',
            'vo_nummer' => 'bail|min:1|max:100',
            'vo_stand' => 'bail|min:1|max:100',
            'vo_name_text' => '',
        ]);
    }

    /**
     * @return array
     */
    public function validateNewVerordnug(): array
    {
        return request()->validate([
            'vo_name_kurz' => 'bail|unique:verordnungs,vo_name_kurz|required|min:1|max:20',
            'vo_name_lang' => 'bail|min:1|max:100',
            'vo_nummer' => 'bail|min:1|max:100',
            'vo_stand' => 'bail|min:1|max:100',
            'vo_name_text' => '',
        ]);
    }

    /**
     * @return array
     */
    public function validateNewAnforderungControlItem(): array
    {
        return request()->validate([
            'aci_name_kurz' => 'bail|alpha_dash|unique:anforderung_control_items,aci_name_kurz|required|max:20',
            'aci_name_lang' => 'required',
            'aci_task' => '',
            'aci_value_si' => 'max:10',
            'aci_vaule_soll' => '',
            'firma_id' => '',
            'aci_contact_id' => 'required',
            'anforderung_id' => 'required',
        ]);
    }

    /**
     * @return array
     */
    public function validateAnforderungControlItem(): array
    {
        return request()->validate([
            'aci_name_kurz' => 'bail|alpha_dash|required|max:20',
            'aci_name_lang' => 'max:150',
            'aci_task' => '',
            'aci_value_si' => 'max:10',
            'aci_vaule_soll' => '',
            'firma_id' => '',
            'aci_contact_id' => 'required',
            'anforderung_id' => 'required',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @return Response
     */
    public function createAjaxBuildingType(Request $request)
    {
        $bt = BuildingTypes::create($this->validateBuldingTypes());
        return $bt;
    }



    public function getUsedAdressesByAdressType(Address $adress, Request $adt_id)
    {
        return $adress->where('address_type_id',$adt_id->id)->get();
    }

    public function getUsedBuildingsByBuildingType(Building $building, Request $btid)
    {
        return $building->where('building_type_id',$btid->id)->get();
    }

    public function getUsedRoomsByRoomType(Room $room, Request $btid)
    {
        return $room->where('room_type_id',$btid->id)->get();
    }

    public function getUsedProdukteByKategorie(Produkt $produkt, Request $btid)
    {
        return $produkt->where('produkt_kategorie_id',$btid->id)->get();
    }

    public function getUsedObjByStellPlatzType(Produkt $room, Request $btid)
    {
        return false;
    }

    public function getUsedEquipmentByProdAnforderung(Produkt $room, Request $btid)
    {
        return false;
    }

    public function getUsedDokuTypeProderial(Produkt $materialStamm, Request $btid)
    {
        return false;
    }

    public function getStandortIdListAll(Request $request)
    {
        $loc = DB::table('standorts')->select(
            DB::raw('standorts.id,std_kurzel,standorts.std_id,l_name_lang as name_lang')
        )->distinct()
            ->join('locations', 'standorts.std_id', '=', 'locations.standort_id')
            ->where('std_kurzel','like', '%'.$request->term . '%')
            ->orWhere('l_name_lang','like', '%'.$request->term . '%')
            ->orWhere('l_beschreibung','like', '%'.$request->term . '%')
            ->get();

        $bul = DB::table('standorts')->select(
            DB::raw('standorts.id,std_kurzel,standorts.std_id,b_name_lang as name_lang')
        )->distinct()
            ->join('buildings', 'standorts.std_id', '=', 'buildings.standort_id')
            ->where('std_kurzel','like', '%'.$request->term . '%')
            ->orWhere('b_name_lang','like', '%'.$request->term . '%')
            ->orWhere('b_name_text','like', '%'.$request->term . '%')
            ->get();

        $rom = DB::table('standorts')->select(
            DB::raw('standorts.id,std_kurzel,standorts.std_id,r_name_lang as name_lang')
        )->distinct()
            ->join('rooms', 'standorts.std_id', '=', 'rooms.standort_id')
            ->where('std_kurzel','like', '%'.$request->term . '%')
            ->orWhere('r_name_lang','like', '%'.$request->term . '%')
            ->orWhere('r_name_text','like', '%'.$request->term . '%')
            ->get();

        $stp = DB::table('standorts')->select(
            DB::raw('standorts.id,std_kurzel,standorts.std_id,sp_name_lang as name_lang')
        )->distinct()
            ->join('stellplatzs', 'standorts.std_id', '=', 'stellplatzs.standort_id')
            ->where('std_kurzel','like', '%'.$request->term . '%')
            ->orWhere('sp_name_lang','like', '%'.$request->term . '%')
            ->orWhere('sp_name_text','like', '%'.$request->term . '%')
            ->get();

        return ['loc'=>$loc,'bul'=>$bul,'rom'=>$rom,'stp'=>$stp];
    }

}
