<?php

namespace App\Http\Controllers;

use App\Anforderung;
use App\AnforderungControlItem;
use App\AnforderungObjekt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnforderungsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        AnforderungObjekt::create($this->validateObjektAnforderung());

        $request->session()->flash('status', 'Die Anforderung <strong>' . request('an_name_kurz') . '</strong> wurde zugewiesen!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Anforderung $anforderung
     * @return Response
     */
    public function show(Anforderung $anforderung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Anforderung $anforderung
     * @return Response
     */
    public function edit(Anforderung $anforderung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Anforderung              $anforderung
     * @return Response
     */
    public function update(Request $request, Anforderung $anforderung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Anforderung $anforderung
     * @return RedirectResponse
     */
    public function destroy(Request $request,Anforderung $anforderung)
    {
        $prodDoku = AnforderungObjekt::find($request->id);
//        dd($prodDoku->proddoc_name_pfad);
        $prodDoku->delete();
        session()->flash('status', 'Die Anforderung wurde gelöscht!');
        return redirect()->back();
    }

    static function getACI($anforderung_id) {
        return AnforderungControlItem::where('anforderung_id',$anforderung_id)-get();
    }

    /**
     * @return array
     */
    public function validateObjektAnforderung(): array
    {
        return request()->validate([
            'std_id' => 'required',
            'anforderung_id' => 'required',
        ]);
    }
}
