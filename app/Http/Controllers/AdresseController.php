<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Location;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdresseController extends Controller
{

    use SoftDeletes;

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
        $adresseList = Adresse::with('AddressType')->paginate(15);
        return view('admin.organisation.adresse.index', ['adresseList' => $adresseList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.organisation.adresse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $adresse = Adresse::create($this->validateNewAddress());
        $text = '';

        if (isset($request->setAdressAsNewMain)) {

            $location = Location::find($request->setAdressAsNewMain);
            $location->adresse_id = $adresse->id;
            $location->save();
            $text = ' und als neue Hauptadresse des Standort ' . $location->l_label . ' gesetzt';
        }

        $request->session()->flash('status', "Die Adresse <strong>{$request->ad_name}</strong> wurde angelegt {$text}!");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Adresse $adresse
     * @return Application|Factory|Response|View
     */
    public function show(Adresse $adresse)
    {
        return view('admin.organisation.adresse.show', ['adresse' => $adresse]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Adresse $adresse
     * @return Response
     */
    public function edit(Adresse $adresse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Adresse $adresse
     * @return RedirectResponse
     */
    public function update(Request $request, Adresse $adresse)
    {
        $adresse->update($this->validateAddress());
        $request->session()->flash('status', 'Die Adresse <strong>' . $adresse->ad_label . '</strong> wurde aktualisiert!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Adresse $adresse
     * @return Response
     */
    public function destroy(Adresse $adresse)
    {
        // getAddressenAjaxListe
    }

    public function getAddressenAjaxListe(Request $request)
    {

        return   DB::table('adresses')->select(
            'id',
            'ad_name_firma',
            'ad_anschrift_ort',
            'ad_anschrift_strasse',
            'ad_name',
            'ad_label',
            'land_id',
            'ad_anschrift_plz'
        )
            ->Where('ad_name_firma', 'like', '%' . $request->term . '%')
            ->orWhere('ad_label', 'like', '%' . $request->term . '%')
            ->orWhere('ad_name', 'like', '%' . $request->term . '%')
            ->orWhere('ad_anschrift_ort', 'like', '%' . $request->term . '%')
            ->orWhere('ad_anschrift_plz', 'like', '%' . $request->term . '%')
            ->orWhere('ad_anschrift_strasse', 'like', '%' . $request->term . '%')
            ->get();
    }

    public function getAddressDaten(Request $request)
    {
        $adresses = Adresse::all();
        $adresses->find($request->id);

        return [
            'adressListe' => $adresses
        ];
    }

    /**
     * @return array
     */
    public function validateNewAddress(): array
    {
        return request()->validate([
            'ad_label' => 'bail|required|unique:adresses,ad_label|max:20',
            'ad_name' => 'max:100',
            'ad_name_firma' => 'max:100',
            'ad_name_firma_2' => 'max:100',
            'ad_name_firma_co' => 'max:100',
            'ad_name_firma_abladestelle' => 'max:100',
            'ad_name_firma_wareneingang' => 'max:100',
            'ad_name_firma_abteilung' => 'max:100',
            'ad_anschrift_strasse' => 'required|max:100',
            'ad_anschrift_hausnummer' => 'max:100',
            'ad_anschrift_etage' => 'max:100',
            'ad_anschrift_eingang' => 'max:100',
            'ad_anschrift_plz' => 'required|max:100',
            'ad_anschrift_ort' => 'required|max:100',
            'adresse_type_id' => '',
            'land_id' => '',

        ]);
    }
    /**
     * @return array
     */
    public function validateAddress(): array
    {

        return request()->validate([
            'ad_label' => 'required|max:20',
            'ad_name' => 'max:100',
            'ad_name_firma' => 'max:100',
            'ad_name_firma_2' => 'max:100',
            'ad_name_firma_co' => 'max:100',
            'ad_name_firma_abladestelle' => 'max:100',
            'ad_name_firma_wareneingang' => 'max:100',
            'ad_name_firma_abteilung' => 'max:100',
            'ad_anschrift_strasse' => 'required|max:100',
            'ad_anschrift_hausnummer' => 'max:100',
            'ad_anschrift_etage' => 'max:100',
            'ad_anschrift_eingang' => 'max:100',
            'ad_anschrift_plz' => 'required|max:100',
            'ad_anschrift_ort' => 'required|max:100',
            'adresse_type_id' => '',
            'land_id' => '',

        ]);
    }
}
