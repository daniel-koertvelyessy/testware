<?php

namespace App\Http\Controllers;

use App\EquipmentDoc;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class EquipmentDocController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'downloadEquipmentDokuFile',
            'index'
        ]);
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
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('equipDokumentFile')) {

            $proDocFile = new EquipmentDoc();
            $file = $request->file('equipDokumentFile');
            $request->validate([
                'equipDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg|max:20480',
                // size:2048 => 2048kB
                'eqdoc_label'       => 'required|max:150'
            ]);

            //dd($file->getClientMimeType(),$file->getClientOriginalExtension(),$file->getClientOriginalName());

            $proDocFile->eqdoc_name = $file->getClientOriginalName();
            $proDocFile->eqdoc_name_pfad = $file->store('equipment_docu/' . \request('equipment_id'));
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->equipment_id = request('equipment_id');
            $proDocFile->eqdoc_description = request('eqdoc_description');
            $proDocFile->eqdoc_label = request('eqdoc_label');
            $request->session()->flash('status', __('Das Dokument <strong>:name</strong> wurde hochgeladen!',['name'=>$file->getClientOriginalName()]));
            $proDocFile->save();
            // $file->storeAs($pfad, $Dateiname->guessExtention() ); => Storage::disk('local')->putFileAs($pfad, $file, $Dateiname->guessExtention());
            // $file->store($pfad) => Storage::disk('local')->putFile($pfad, $file);
            // 'local' oder 'public' oder default, wenn nicht angegeben

        } else {
            $request->session()->flash('status', __('Das Dokument <strong>:label</strong> konnte nicht hochgeladen werden!',['label'=>request('doctyp_label')]));
        }
        //
        return redirect()->back();
    }

    public function downloadEquipmentDokuFile(Request $request)
    {
        $doc = EquipmentDoc::find($request->id);
        return response(Storage::disk('local')->get($doc->eqdoc_name_pfad), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', Storage::mimeType($doc->eqdoc_name_pfad))
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=" . $doc->eqdoc_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
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
     * @return Response
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
        $file = $prodDoku->eqdoc_name;
        Storage::delete($prodDoku->eqdoc_name_pfad);
        $prodDoku->delete();
        session()->flash('status', __('Das Dokument <strong>:name</strong> wurde gelöscht!',['name'=>$file]));
        return redirect()->back();
    }


    public function equipDoku()
    {
    }
}
