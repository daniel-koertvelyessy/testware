<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Contact;
use App\Firma;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FirmaController extends Controller
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
        $firmaList = Firma::with('Adresse')->paginate(15);
        return view('admin.organisation.firma.index', ['firmaList' => $firmaList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.organisation.firma.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Application|Factory|Response|View
     */
    public function store(Request $request)
    {
        if ($request->adresse_id === 'new') $request->adresse_id = (new Adresse)->addNew($request);

        $firma_id = (new Firma)->addCompany($request);

        $request->session()->flash('status', __('Die Firma <strong>:label</strong> wurde angelegt!',['label' => $request->fa_label]));
        return view('admin.organisation.firma.show', ['firma' => Firma::find($firma_id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param Firma $firma
     *
     * @return Application
     */
    public function show(Firma $firma)
    {
        return view('admin.organisation.firma.show', ['firma' => $firma]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Firma $firma
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Firma $firma)
    {
        $this->validateFirma();
        $firma->fa_label = $request->fa_label;
        $firma->fa_name = $request->fa_name;
        $firma->fa_description = $request->fa_description;
        $firma->fa_kreditor_nr = $request->fa_kreditor_nr;
        $firma->fa_debitor_nr = $request->fa_debitor_nr;
        $firma->fa_vat = $request->fa_vat;
        $firma->adresse_id = $request->adresse_id;
        if ($firma->save()){
            $request->session()->flash('status', __('Die Firma <strong>:label</strong> wurde aktualisiert!', ['label' => $request->fa_label]));
        } else {
            $request->session()->flash('status', __('Die Firma <strong>:label</strong> konnte nicht aktualisiert werden!', ['label' => $request->fa_label]));
            Log::error('Error on update company');
        }



        return redirect()->back();
    }

    /**
     * @return array
     */
    public function validateFirma(): array
    {
        return request()->validate([
            'fa_label' => [
                'bail',
                'max:20',
                'required',
                Rule::unique('firmas')->ignore(\request('id'))
            ],
            'fa_name' => [
                'bail',
                'string',
                'max:100'
            ],
            'fa_description' => '',
            'fa_kreditor_nr' => [
                'bail',
                'max:100',
                Rule::unique('firmas')->ignore(\request('id'))
            ],
            'fa_debitor_nr' => 'max:100',
            'fa_vat' => 'max:30',
            'adresse_id' => '',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Firma $firma
     * @param Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function destroy(Firma $firma, Request $request)
    {
        $request->session()->flash('status', __('Die Firma <strong>:label</strong> wurde gelöscht!', ['label' => $firma->fa_label]));
        $firma->delete();
        return redirect(route('firma.index'));
    }

    /*
 *
 *
 *
 *    AJAX
 *
 *
 */

    public function getFirmenAjaxListe(Request $request)
    {
        return DB::table('firmas')->select('fa_label', 'firmas.id', 'firmas.fa_name', 'ad_name_firma', 'ad_anschrift_ort', 'ad_anschrift_strasse', 'fa_kreditor_nr', 'fa_debitor_nr')->join('adresses', 'adresses.id', '=', 'firmas.adresse_id')->where('fa_label', 'like', '%' . $request->term . '%')->orWhere('fa_name', 'like', '%' . $request->term . '%')->orWhere('fa_description', 'like', '%' . $request->term . '%')->orWhere('fa_kreditor_nr', 'like', '%' . $request->term . '%')->orWhere('fa_debitor_nr', 'like', '%' . $request->term . '%')->orWhere('fa_vat', 'like', '%' . $request->term . '%')->orWhere('ad_name_firma', 'like', '%' . $request->term . '%')->orWhere('ad_anschrift_ort', 'like', '%' . $request->term . '%')->orWhere('ad_anschrift_plz', 'like', '%' . $request->term . '%')->orWhere('ad_anschrift_strasse', 'like', '%' . $request->term . '%')->get();
    }

    public function getFirmaData(Request $request)
    {
        //        dd($request);
        return Firma::find($request->id);
    }


    public function getFirmenDaten(Request $request)
    {
        $firma = Firma::find($request->id);

        $adresses = Adresse::find($firma->adresse_id);

        $contact = Contact::where('firma_id', $request->id)->first();

        return [
            'firma' => $firma,
            'adresse' => $adresses,
            'contact' => $contact
        ];
    }

    /**
     *  Checks if a company exists with such a label
     *
     * @param Request $request
     *
     * @return bool
     */
    public function checkCompanyLabel(Request $request): bool
    {
        return json_encode(Firma::where('fa_label', $request->label)->count() > 0);
    }

    /**
     *  Checks if a company exists with such a label
     *
     * @param Request $request
     *
     * @return bool
     */
    public function checkCompanyKreditor(Request $request): bool
    {
        return json_encode(Firma::where('fa_kreditor_nr', $request->kreditor)->count() > 0);
    }
}
