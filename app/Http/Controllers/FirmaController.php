<?php

namespace App\Http\Controllers;

use App\Adresse;
use App\Contact;
use App\Firma;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        return view('admin.organisation.firma.index',['firmaList'=>$firmaList]);
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
     * @param  Request $request
     * @return Application|Factory|Response|View
     */
    public function store(Request $request)
    {
       $firma = Firma::create($this->validateNewFirma());
        $request->session()->flash('status', 'Die Firma <strong>' . $firma->fa_name_kurz . '</strong> wurde angelegt!');
        return view('admin.organisation.firma.show',['firma'=>$firma]);
    }


    /**
     * Display the specified resource.
     *
     * @param  Firma $firma
     * @return Application
     */
    public function show(Firma $firma)
    {
        return view('admin.organisation.firma.show',['firma'=>$firma]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Firma $firma
     * @return Response
     */
    public function edit(Firma $firma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Firma   $firma
     * @return RedirectResponse
     */
    public function update(Request $request, Firma $firma)
    {
        $firma->update($this->validateFirma());
        $request->session()->flash('status', 'Die Firma <strong>' . $firma->fa_name_kurz . '</strong> wurde aktualisiert!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Firma $firma
     * @return Response
     */
    public function destroy(Firma $firma)
    {
        //
    }


    /**
     * @return array
     */
    public function validateNewFirma(): array
    {
        return request()->validate([
            'fa_name_kurz' => 'bail|unique:firmas,fa_name_kurz|max:20|required',
            'fa_name_lang' => 'bail|string|max:100',
            'fa_name_text' => '',
            'fa_kreditor_nr' => 'bail|unique:firmas,fa_kreditor_nr|max:100',
            'fa_debitor_nr' => 'max:100',
            'fa_vat' => 'max:30',
            'adress_id' => '',
        ]);
    }

    /**
     * @return array
     */
    public function validateFirma(): array
    {
        return request()->validate([
            'fa_name_kurz' => 'bail|max:20|required',
            'fa_name_lang' => 'bail|string|max:100',
            'fa_name_text' => '',
            'fa_kreditor_nr' => 'bail|max:100',
            'fa_debitor_nr' => 'max:100',
            'fa_vat' => 'max:30',
            'adresse_id' => '',
        ]);
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
       return   DB::table('firmas')->select(
           'fa_name_kurz',
           'firmas.id',
           'firmas.fa_name_lang',
           'ad_name_firma',
           'ad_anschrift_ort',
           'ad_anschrift_strasse',
           'fa_kreditor_nr',
           'fa_debitor_nr'
                )
            ->join('adresses', 'adresses.id', '=', 'firmas.adresse_id')
            ->where('fa_name_kurz','like', '%'.$request->term . '%')
            ->orWhere('fa_name_lang','like', '%'.$request->term . '%')
            ->orWhere('fa_name_text','like', '%'.$request->term . '%')
            ->orWhere('fa_kreditor_nr','like', '%'.$request->term . '%')
            ->orWhere('fa_debitor_nr','like', '%'.$request->term . '%')
            ->orWhere('fa_vat','like', '%'.$request->term . '%')
            ->orWhere('ad_name_firma','like', '%'.$request->term . '%')
            ->orWhere('ad_anschrift_ort','like', '%'.$request->term . '%')
            ->orWhere('ad_anschrift_plz','like', '%'.$request->term . '%')
            ->orWhere('ad_anschrift_strasse','like', '%'.$request->term . '%')
            ->get();

    }

    public function getFirmaData(Request $request) {
//        dd($request);
        return Firma::find($request->id);
    }


    public function getFirmenDaten(Request $request)
    {
        $firma = Firma::find($request->id);

//        dd($firma->adresse_id);

        $adresses = Adresse::find($firma->adresse_id);

        $contact = Contact::where('firma_id',$request->id)->first();

        return [
            'firma' => $firma,
            'adresse' => $adresses,
            'contact' => $contact
        ];


    }
}
