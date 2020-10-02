<?php

namespace App\Http\Controllers;

use App\Address;
use App\Contact;
use App\Firma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FirmaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function show(Firma $firma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function edit(Firma $firma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Firma $firma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
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
            ->join('addresses', 'addresses.id', '=', 'firmas.address_id')
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

        $adresses = Address::find($firma->address_id);

        $contact = Contact::where('firma_id',$request->id)->first();

        return [
            'firma' => $firma,
            'adresse' => $adresses,
            'contact' => $contact
        ];


    }
}
