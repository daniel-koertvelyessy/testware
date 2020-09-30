<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
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
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        // getAddressenAjaxListe
    }

    public function getAddressenAjaxListe(Request $request)
    {

        return   DB::table('addresses')->select(
            'id',
            'ad_name_firma',
            'ad_anschrift_ort',
            'ad_anschrift_strasse',
            'ad_name_lang',
            'ad_name_kurz',
            'land_id',
            'ad_anschrift_plz'
        )
            ->Where('ad_name_firma','like', '%'.$request->term . '%')
            ->orWhere('ad_name_kurz','like', '%'.$request->term . '%')
            ->orWhere('ad_name_lang','like', '%'.$request->term . '%')
            ->orWhere('ad_anschrift_ort','like', '%'.$request->term . '%')
            ->orWhere('ad_anschrift_plz','like', '%'.$request->term . '%')
            ->orWhere('ad_anschrift_strasse','like', '%'.$request->term . '%')
            ->get();

    }

    public function getAddressDaten(Request $request)
    {
        $adresses = Address::all();
        $adresses->find($request->id);

        return [
            'adressListe' => $adresses
        ];


    }

}
