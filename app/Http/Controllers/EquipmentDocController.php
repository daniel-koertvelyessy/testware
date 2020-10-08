<?php

namespace App\Http\Controllers;

use App\EquipmentDoc;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentDocController extends Controller
{
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
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('equipDokumentFile')) {

            $proDocFile = new EquipmentDoc();
            $file = $request->file('equipDokumentFile');

            $validation = $request->validate([
                'equipDokumentFile'  =>  'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:10240' // size:2048 => 2048kB
            ]);

//dd($file->getClientMimeType(),$file->getClientOriginalExtension(),$file->getClientOriginalName());

            $proDocFile->eqdoc_name_lang = $file->getClientOriginalName();
            $proDocFile->eqdoc_name_pfad= $file->store('equipment_docu/'.\request('equipment_id'));
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->equipment_id = request('equipment_id');
            $proDocFile->eqdoc_name_text = request('eqdoc_name_text');
            $proDocFile->eqdoc_name_kurz = request('eqdoc_name_kurz');
            $request->session()->flash('status', 'Das Dokument <strong>' . $file->getClientOriginalName() . '</strong> wurde hochgeladen!');
            $proDocFile->save();
            // $file->storeAs($pfad, $Dateiname->guessExtention() ); => Storage::disk('local')->putFileAs($pfad, $file, $Dateiname->guessExtention());
            // $file->store($pfad) => Storage::disk('local')->puFile($pfad, $file);
            // 'local' oder 'public' oder default, wenn nicht angegeben

        } else {
            $request->session()->flash('status', 'Das Dokument <strong>' . request('doctyp_name_kurz') . '</strong> konnte nicht hochgeladen werden!');

        }
//
        return redirect()->back();
    }

    public function downloadProduktDokuFile(Request $request)
    {
        $doc = EquipmentDoc::find($request->id);
        return response(Storage::disk('local')->get($doc->eqdoc_name_pfad), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', Storage::mimeType($doc->eqdoc_name_pfad))
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=".$doc->eqdoc_name_lang)
            ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        $prodDoku = EquipmentDoc::find($request->id);
//        dd($prodDoku->proddoc_name_pfad);
        $file = $prodDoku->proddoc_name_lang;
        Storage::delete($prodDoku->proddoc_name_pfad);
        $prodDoku->delete();
        session()->flash('status', 'Das Dokument <strong>' . $file . '</strong> wurde gelöscht!');
        return redirect()->back();
    }

    public function equipDoku() {

    }
}
