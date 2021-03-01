<?php

namespace App\Http\Controllers;

use App\AddressType;
use App\Adresse;
use App\Anforderung;
use App\AnforderungControlItem;
use App\AnforderungType;
use App\Building;
use App\BuildingTypes;
use App\ControlProdukt;
use App\DocumentType;
use App\Equipment;
use App\EquipmentFuntionControl;
use App\EquipmentQualifiedUser;
use App\ProductQualifiedUser;
use App\Produkt;
use App\ProduktKategorie;
use App\Room;
use App\RoomType;
use App\StellplatzTyp;
use App\Storage;
use App\User;
use App\Verordnung;
use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

//use App\BuildingType;

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
        $system = $this::getSystemStatus();
        return view('admin.index', compact('system'));
    }

    public static function getSystemStatus()
    : array
    {
        $incomplete_equipment = false;
        $incomplete_requirement = 0;
        foreach (Anforderung::all() as $requirement) {
            $incomplete_requirement += $requirement->AnforderungControlItem()->count() > 0 ? 0 : 1;
        }

        $countEquipment = Equipment::all()->count();

        if ($countEquipment > 0) {
            $countEquipmentFunctionTest = EquipmentFuntionControl::all()->count();
            $incomplete_equipment = $countEquipment - $countEquipmentFunctionTest;
        }

        return Cache::remember('system-status-counter', now()->addSeconds(10), function () use ($incomplete_requirement, $countEquipment, $incomplete_equipment) {
            return [
                'products'                 => Produkt::all()->count(),
                'equipment'                => $countEquipment,
                'control_products'         => ControlProdukt::all()->count(),
                'storages'                 => Storage::all()->count(),
                'equipment_qualified_user' => EquipmentQualifiedUser::all()->count(),
                'product_qualified_user'   => ProductQualifiedUser::all()->count(),
                'regulations'              => Verordnung::all()->count(),
                'requirements'             => Anforderung::all()->count(),
                'incomplete_requirement'   => $incomplete_requirement,
                'incomplete_equipment'     => $incomplete_equipment,
                'requirements_items'       => AnforderungControlItem::all()->count(),
            ];
        });

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

    public function storageDataPort()
    {
        return view('admin.standorte.dataport');
    }

    public function checkStorageValid(Request $request)
    {
        //
        $bul = DB::table('buildings')->select('id')->where('b_label', 'like', '%' . $request->name . '%')->orWhere('b_name_ort', 'like', '%' . $request->name . '%')->orWhere('b_name', 'like', '%' . $request->name . '%')->orWhere('b_description', 'like', '%' . $request->name . '%')->orWhere('b_we_name', 'like', '%' . $request->name . '%')->get();

        $rom = DB::table('rooms')->select('id')->where('r_label', 'like', '%' . $request->name . '%')->orWhere('r_name', 'like', '%' . $request->name . '%')->orWhere('r_description', 'like', '%' . $request->name . '%')->get();

        $spl = DB::table('stellplatzs')->select('id')->where('sp_label', 'like', '%' . $request->name . '%')->orWhere('sp_name', 'like', '%' . $request->name . '%')->orWhere('sp_description', 'like', '%' . $request->name . '%')->get();

        return ($bul->count() > 0 || $rom->count() > 0 || $spl->count() > 0) ? 1 : 0;
    }

    /**
     *  Aktualisiert die CSS-Datei zur Darstellung von Farben und Schriften
     *
     * @param  Request $request
     * @param  User    $adt
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateUserTheme(Request $request, User $adt)
    {
        $data = User::find($request->id);
        $data->user_theme = $request->systemTheme;
        $data->save();
        // $data->update($request->systemTheme);

        $request->session()->flash('status', 'Das Theme wurde aktualisiert!');
        return redirect()->back();
    }

    public function addObjektAnforderung(Request $request)
    {
    }

    /**
     * Speichert einen neuen Adresstyp
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createAddressType(Request $request)
    {
        AddressType::create($this->validateAdressTypes());

        $request->session()->flash('status', 'Der Adresstyp <strong>' . request('adt_name') . '</strong> wurde angelegt!');
        return back();
    }

    /**
     * @return array
     */
    public function validateAdressTypes()
    : array
    {
        return request()->validate([
            'adt_name'      => 'bail|required|min:1|max:20',
            'adt_text_lang' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request     $request
     * @param  AddressType $adt
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateAddressType(Request $request, AddressType $adt)
    {
        $data = AddressType::find($request->id);
        $data->update($this->validateAdressTypes());
        $request->session()->flash('status', 'Der Adresstyp <strong>' . $data->adt_name . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $id
     *
     * @return Response
     */
    public function getAddressTypeData(Request $id)
    {
        $data = AddressType::find($id);
        return $data;
    }


    /**
     *   ENDE   A D R E S S   T Y P E S
     */

    /**
     * @param  Request     $request
     * @param  AddressType $adt
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteTypeAdress(Request $request, AddressType $adt)
    {

        //        dd(, $adt->id);

        AddressType::destroy($request->id);
        $request->session()->flash('status', 'Der Adresstyp wurde gelöscht!');
        return back();
    }

    /**
     * Speichere einen neuen Gebäudetyp.
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createBuildingType(Request $request)
    {
        BuildingTypes::create($this->validateNewBuldingTypes());

        $request->session()->flash('status', 'Der Gebäudetyp <strong>' . request('btname') . '</strong> wurde angelegt!');
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateNewBuldingTypes()
    : array
    {
        return request()->validate([
            'btname'         => 'bail|unique:building_types,btname|required|min:1|max:20',
            'btbeschreibung' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request       $request
     * @param  BuildingTypes $adt
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateBuildingType(Request $request, BuildingTypes $adt)
    {
        $data = BuildingTypes::find($request->id);
        $data->update($this->validateBuldingTypes());

        $request->session()->flash('status', 'Der Gebäudetyp <strong>' . request('btname') . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * @return array
     */
    public function validateBuldingTypes()
    : array
    {
        return request()->validate([
            'btname'         => 'bail|required|min:1|max:20',
            'btbeschreibung' => ''
        ]);
    }

    /**
     * Ende Product types
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  Request       $request
     * @param  BuildingTypes $adt
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function deleteBuildingType(Request $request, BuildingTypes $adt)
    {
        $data = BuildingTypes::destroy($request->id);
        $request->session()->flash('status', 'Der Gebäudetyp <strong>' . request('btname') . '</strong> wurde gelöscht!');
        return back();
    }

    /**
     * Show the form for creating a new resource.
     * *
     *
     * @param  Request $id
     *
     * @return Response
     */
    public function getBuildingTypeData(Request $id)
    {
        $data = BuildingTypes::find($id);
        return $data;
        // return response()->json($data);
    }

    public function getBuildingTypeList()
    {
        $data['html'] = '';
        foreach (BuildingTypes::all() as $bt) {
            $data['html'] .= '
           <option value="' . $bt->id . '">' . $bt->btname . '</option>
           ';
        }

        return $data;
        // return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createRoomType(Request $request)
    {

        $rt = RoomType::create($this->validateNewRoomTypes());

        $request->session()->flash('status', 'Der Gebäudetyp <strong>' . request('rt_label') . '</strong> wurde angelegt!');
        return redirect()->back();
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
     * @return array
     */
    public function validateNewRoomTypes()
    : array
    {
        return request()->validate([
            'rt_label'       => 'bail|unique:room_types,rt_label|required|min:1|max:20',
            'rt_name'        => 'max:100',
            'rt_description' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  RoomType $rmt
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateRoomType(Request $request, RoomType $rmt)
    {
        $data = RoomType::findOrFail($request->id);
        $data->update($this->validateRoomTypes());
        $request->session()->flash('status', 'Der Raumtyp <strong>' . request('rt_label') . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * @return array
     */
    public function validateRoomTypes()
    : array
    {
        return request()->validate([
            'rt_label'       => 'bail|required|min:1|max:20',
            'rt_name'        => 'max:100',
            'rt_description' => ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * *
     *
     * @param  Request $id
     *
     * @return Response
     */
    public function getRoomTypeData(Request $id)
    {
        $data = RoomType::findOrFail($id->id);
        return $data;
        // return response()->json($data);
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
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteRoomType(Request $request)
    {
        RoomType::destroy($request->id);
        $request->session()->flash('status', 'Der Raumtyp wurde gelöscht!');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function createStellPlatzType(Request $request)
    {
        StellplatzTyp::create($this->validateNewStellPlatzTypes());

        $request->session()->flash('status', 'Der Stellplatztyp <strong>' . request('spt_label') . '</strong> wurde angelegt!');

        return back();
    }

    /**
     * @return array
     */
    public function validateStellPlatzTypes()
    : array
    {
        return request()->validate([
            'spt_label'       => [
                'bail',
                'required',
                'min:1',
                'max:20',
                Rule::unique('stellplatz_typs')->ignore(\request('id'))
            ],
            'spt_name'        => 'max:100',
            'spt_description' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request       $request
     * @param  StellplatzTyp $StellPlatzTyp
     *
     * @return Response
     */
    public function updateStellPlatzType(Request $request, StellplatzTyp $StellPlatzTyp)
    {
        $data = StellplatzTyp::findOrFail($request->id);
        $data->update($this->validateStellPlatzTypes());
        $request->session()->flash('status', 'Der Stellplatztyp <strong>' . request('spt_label') . '</strong> wurde aktualisiert!');
        return back();
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
     * Show the form for creating a new resource.
     * * @param  Request $request
     *
     * @return Response
     */
    public function getStellPlatzTypeData(Request $id)
    {
        $data = StellplatzTyp::findOrFail($id->id);
        return $data;
    }

    /**
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteStellPlatzType(Request $request)
    {
        StellplatzTyp::destroy($request->id);
        $request->session()->flash('status', 'Der Stellplatztyp wurde gelöscht!');
        return back();
    }

    /**
     * Show the form for creating a new resource. control_interval_id
     * *
     * @* param Request $id
     * @* return string
     * public function getAnforderungByVerordnungListe(Request $request)
     * {
     * $data['id'] = $request->id;
     * $data['html']='<option>bitte Anordnung wählen</option>';
     * foreach (Anforderung::where('verordnung_id',$request->id)->get() as $anf){
     * $data['html'].='
     * <option value="'.$anf->id.'"
     * data-textlang="'.$anf->an_name.'"
     * >'.$anf->an_label.'</option>
     * ';
     * }
     * return $data;
     * }
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createProdKat(Request $request)
    {
        ProduktKategorie::create($this->validateProduktKategorie());

        $request->session()->flash('status', __('Die Produktkategorie') . ' <strong>' . request('pk_label') . '</strong> ' . __('wurde angelegt!'));
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateProduktKategorie()
    : array
    {
        return request()->validate([
            'pk_label'       => 'bail|required|min:1|max:20',
            'pk_name'        => 'bail|min:1|max:100',
            'pk_description' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request          $request
     * @param  ProduktKategorie $produktKategorie
     *
     * @return RedirectResponse
     */
    public function updateProdKat(Request $request, ProduktKategorie $produktKategorie)
    {
        $data = ProduktKategorie::findOrFail($request->id);
        $data->update($this->validateProduktKategorie());
        $request->session()->flash('status', 'Die Produkt-Kategorie <strong>' . request('pk_label') . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * Show the form for creating a new resource.
     * * @param  Request $request
     *
     * @return Response
     */
    public function getProdKatData(Request $id)
    {
        $data = ProduktKategorie::findOrFail($id->id);
        return $data;
    }

    /**
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteProdKat(Request $request)
    {
        ProduktKategorie::destroy($request->id);
        $request->session()->flash('status', 'Die Produkt-Kategorie wurde gelöscht!');
        return back();
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
     * Show the form for creating a new resource.
     * *
     *
     * @param  Request $id
     *
     * @return Response
     */
    public function getVerordnungData(Request $id)
    {
        return Verordnung::findOrFail($id->id);
    }

    /**
     * Aktualisiere die gegebene Anforderung
     *
     * @param  Request     $request
     * @param  Anforderung $anforderung
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateAnforderung(Request $request, Anforderung $anforderung)
    {
        $data = Anforderung::findOrFail($request->id);
        $data->update($this->validateAnforderung());
        $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_label') . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * Show the form for creating a new resource.
     * *
     *
     * @param  Request $id
     *
     * @return Builder|Builder[]|Collection|Model|Response
     */
    public function getAnforderungData(Request $id)
    {
        return Anforderung::with('verordnung', 'ControlInterval')->findOrFail($id->id);
    }

    /**
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteAnforderung(Request $request)
    {
        Anforderung::destroy($request->id);
        $request->session()->flash('status', 'Die Die Anforderung wurde gelöscht!');
        return back();
    }

    public function addNewAnforderungType(Request $request)
    {
        AnforderungType::create($this->validateNewAnforderungType());
        $request->session()->flash('status', 'Der Prüfungstyp <strong>' . request('at_label') . '</strong> wurde angelegt!');
        return back();
    }

    /**
     * @return array
     */
    public function validateNewAnforderungType()
    : array
    {
        return request()->validate([
            'at_label'       => 'bail|required|unique:anforderung_types,at_label|max:20',
            'at_name'        => 'bail|max:100',
            'at_description' => '',
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

    public function updateAnforderungType(Request $request)
    {
        $data = AnforderungType::findOrFail($request->id);
        $data->update($this->validateAnforderungType());
        $request->session()->flash('status', 'Der Anforderung-Typ <strong>' . request('at_name') . '</strong> wurde aktualisiert!');
        return back();
    }

    /**
     * @return array
     */
    public function validateAnforderungType()
    : array
    {
        return request()->validate([
            'at_label'       => 'bail|required|max:20',
            'at_name'        => 'bail|max:100',
            'at_description' => '',
        ]);
    }

    public function getAnforderungTypData(Request $request)
    {
        return AnforderungType::findOrFail($request->id);
    }

    /**
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteAnforderungType(Request $request)
    {
        Anforderung::destroy($request->id);
        $request->session()->flash('status', 'Der Anforderung-Typ wurde gelöscht!');
        return back();
    }

    /**
     *  Speichere neue Dokzemententyp
     *
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function createDokumentType(Request $request)
    {
        DocumentType::create($this->validateNewDokumentType());
        $request->session()->flash('status', 'Der Dokumententyp <strong>' . request('doctyp_label') . '</strong> wurde angelegt!');

        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateNewDokumentType()
    : array
    {
        return request()->validate([
            'doctyp_label'       => 'bail|required|unique:document_types,doctyp_label|min:1|max:20',
            'doctyp_name'        => 'bail|min:1|max:100',
            'doctyp_description' => '',
            'doctyp_mandatory'   => 'required'
        ]);
    }

    /**
     * Aktualisiere die gegebene Dokzemententyp
     *
     * @param  Request      $request
     * @param  DocumentType $documentype
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function updateDokumentType(Request $request, DocumentType $documentype)
    {
        $data = DocumentType::findOrFail($request->id);
        $data->update($this->validateDokumentType());
        $request->session()->flash('status', 'Der Dokumententyp <strong>' . request('doctyp_label') . '</strong> wurde aktualisiert!');
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateDokumentType()
    : array
    {
        return request()->validate([
            'doctyp_label'       => 'bail|required|min:1|max:20',
            'doctyp_name'        => 'bail|min:1|max:100',
            'doctyp_description' => '',
            'doctyp_mandatory'   => 'required'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * *
     *
     * @param  Request $id
     *
     * @return Response
     */
    public function getDokumentTypeData(Request $id)
    {
        return DocumentType::findOrFail($id->id);
    }

    /**
     * @param  Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function deleteDokumentType(Request $request)
    {
        DocumentType::destroy($request->id);
        $request->session()->flash('status', 'Der Dokumententyp <strong>' . request('doctyp_label') . '</strong> wurde gelöscht!');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function createAjaxBuildingType(Request $request)
    {
        $bt = BuildingTypes::create($this->validateBuldingTypes());
        return $bt;
    }


    public function getUsedAdressesByAdressType(Adresse $adress, Request $adt_id)
    {
        return $adress->where('address_type_id', $adt_id->id)->get();
    }

    public function getUsedBuildingsByBuildingType(Building $building, Request $btid)
    {
        return $building->where('building_type_id', $btid->id)->get();
    }

    public function getUsedRoomsByRoomType(Room $room, Request $btid)
    {
        return $room->where('room_type_id', $btid->id)->get();
    }

    public function getUsedProdukteByKategorie(Produkt $produkt, Request $btid)
    {
        return $produkt->where('produkt_kategorie_id', $btid->id)->get();
    }

    public function getUsedStellplatzByType(Equipment $equipment, Request $request)
    {
        return $equipment->with('produkt')->where('storage_id', $request->id)->get();
    }

    public function getUsedEquipmentByProdAnforderung(Produkt $room, Request $btid)
    {
        return false;
    }

    public function getUsedAnforderungByVerordnung(Anforderung $anforderung, Request $request)
    {
        return $anforderung->where('verordnung_id', $request->id)->get();
    }

    public function getUsedDokuTypeProderial(Produkt $materialStamm, Request $btid)
    {
        return false;
    }

    public function getStorageIdListAll(Request $request)
    {
        $loc = DB::table('storages')->select(DB::raw('storages.id,storage_label,storages.storage_uid,l_name as name'))->distinct()->join('locations', 'storages.storage_uid', '=', 'locations.storage_id')->where('storage_label', 'like', '%' . $request->term . '%')->orWhere('l_name', 'like', '%' . $request->term . '%')->orWhere('l_beschreibung', 'like', '%' . $request->term . '%')->get();

        $bul = DB::table('storages')->select(DB::raw('storages.id,storage_label,storages.storage_uid,b_name as name'))->distinct()->join('buildings', 'storages.storage_uid', '=', 'buildings.storage_id')->where('storage_label', 'like', '%' . $request->term . '%')->orWhere('b_name', 'like', '%' . $request->term . '%')->orWhere('b_description', 'like', '%' . $request->term . '%')->get();

        $rom = DB::table('storages')->select(DB::raw('storages.id,storage_label,storages.storage_uid,r_name as name'))->distinct()->join('rooms', 'storages.storage_uid', '=', 'rooms.storage_id')->where('storage_label', 'like', '%' . $request->term . '%')->orWhere('r_name', 'like', '%' . $request->term . '%')->orWhere('r_description', 'like', '%' . $request->term . '%')->get();

        $stp = DB::table('storages')->select(DB::raw('storages.id,storage_label,storages.storage_uid,sp_name as name'))->distinct()->join('stellplatzs', 'storages.storage_uid', '=', 'stellplatzs.storage_id')->where('storage_label', 'like', '%' . $request->term . '%')->orWhere('sp_name', 'like', '%' . $request->term . '%')->orWhere('sp_description', 'like', '%' . $request->term . '%')->get();

        return [
            'loc' => $loc,
            'bul' => $bul,
            'rom' => $rom,
            'stp' => $stp
        ];
    }

    public function fetchUid()
    {
        return Str::uuid();
    }

}
