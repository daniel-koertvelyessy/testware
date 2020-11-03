<?php

namespace App\Http\Controllers;

use App\Produkt;
use App\ProduktDoc;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProduktDocController extends Controller
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
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        if ($request->hasFile('prodDokumentFile')) {

            $proDocFile = new ProduktDoc();
            $file = $request->file('prodDokumentFile');
            $val = $this->validateNewProduktDokument();

            $validation = $request->validate([
                'prodDokumentFile'  =>  'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg,gif,svg|max:10240' // size:2048 => 2048kB
            ]);

//dd($file->getClientMimeType(),$file->getClientOriginalExtension(),$file->getClientOriginalName());

            $proDocFile->proddoc_name_lang = $file->getClientOriginalName();
            $proDocFile->proddoc_name_pfad= $file->store('produkt_docu/'.\request('produkt_id'));
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->produkt_id = request('produkt_id');
            $proDocFile->proddoc_name_text = request('proddoc_name_text');
            $proDocFile->proddoc_name_kurz = request('proddoc_name_kurz');
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
//

    }

    public function downloadProduktDokuFile(Request $request)
    {

        $doc = ProduktDoc::find($request->id);

        return response(Storage::disk('local')->get($doc->proddoc_name_pfad), 200)
            ->header('Cache-Control', 'public')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', Storage::mimeType($doc->proddoc_name_pfad))
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-disposition', "attachment; filename=".str_replace(',','_',$doc->proddoc_name_lang))
            ;
    }

    /**
     * Display the specified resource.
     *
     * @param  ProduktDoc $produktDoc
     * @return Response
     */
    public function show(ProduktDoc $produktDoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProduktDoc $produktDoc
     * @return Response
     */
    public function edit(ProduktDoc $produktDoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request    $request
     * @param  ProduktDoc $produktDoc
     * @return Response
     */
    public function update(Request $request, ProduktDoc $produktDoc)
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
        $prodDoku = ProduktDoc::find($request->id);
//        dd($prodDoku->proddoc_name_pfad);
        $file = $prodDoku->proddoc_name_lang;
        Storage::delete($prodDoku->proddoc_name_pfad);
        $prodDoku->delete();
        session()->flash('status', 'Das Dokument <strong>' . $file . '</strong> wurde gelöscht!');
        return redirect()->back();

    }

    /**
     * @return array
     */
    public function validateNewProduktDokument(): array
    {
        return request()->validate([
            'proddoc_name_kurz' => 'bail|required|max:150',
            'proddoc_name_lang' => 'max:100',
            'proddoc_name_pfad' => 'max:150',
            'produkt_id' => 'required',
            'document_type_id' => 'required',
            'proddoc_name_text' => ''
        ]);
    }

}
