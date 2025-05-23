<?php

namespace App\Http\Controllers;

use App\ProduktDoc;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProduktDocController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'downloadProduktDokuFile',
            'index',
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
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        if ($request->hasFile('prodDokumentFile')) {
            // mkdir('/var/www/html/storage/app/product_files/');
            $proDocFile = new ProduktDoc;
            $file = $request->file('prodDokumentFile');
            $val = $this->validateNewProduktDokument();

            $validation = $request->validate([
                'prodDokumentFile' => 'required|file|mimes:pdf,tif,tiff,png,jpg,jpeg,gif,svg|max:20480',
                // size:2048 => 2048kB
            ]);

            // dd($file->getClientMimeType(),$file->getClientOriginalExtension(),$file->getClientOriginalName());

            $proDocFile->proddoc_name = $file->getClientOriginalName();
            $proDocFile->proddoc_name_pfad = $file->store('/product_files/'.\request('produkt_id'));
            //            $proDocFile->proddoc_name_pfad = $file->storeAs('product_docu/' . \request('produkt_id'),$file->getClientOriginalName());
            $proDocFile->document_type_id = request('document_type_id');
            $proDocFile->produkt_id = request('produkt_id');
            $proDocFile->proddoc_description = request('proddoc_description');
            $proDocFile->proddoc_label = request('proddoc_label');
            $request->session()->flash('status', 'Das Dokument <strong>'.$file->getClientOriginalName().'</strong> wurde hochgeladen!');
            $proDocFile->save();
            // $file->storeAs($pfad, $Dateiname->guessExtention() ); => Storage::disk('local')->putFileAs($pfad, $file, $Dateiname->guessExtention());
            // $file->store($pfad) => Storage::disk('local')->puFile($pfad, $file);
            // 'local' oder 'public' oder default, wenn nicht angegeben

        } else {
            Log::warning('Fehler beim Hochladen einer Datei. Es wurde kein $_FILE übergeben!');
            $request->session()->flash('status', 'Das Dokument <strong>'.request('doctyp_label').'</strong> konnte nicht hochgeladen werden!');
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
            ->header('Content-disposition', 'attachment; filename='.str_replace(',', '_', $doc->proddoc_name));
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(ProduktDoc $produktDoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(ProduktDoc $produktDoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, ProduktDoc $produktDoc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        $prodDoku = ProduktDoc::find($request->id);
        //        dd($prodDoku->proddoc_name_pfad);
        $file = $prodDoku->proddoc_name;
        Storage::delete($prodDoku->proddoc_name_pfad);
        $prodDoku->delete();
        session()->flash('status', 'Das Dokument <strong>'.$file.'</strong> wurde gelöscht!');

        return redirect()->back();
    }

    public function validateNewProduktDokument(): array
    {
        return request()->validate([
            'proddoc_label' => 'bail|required|max:150',
            'proddoc_name' => 'max:100',
            'proddoc_name_pfad' => 'max:150',
            'produkt_id' => 'required',
            'document_type_id' => 'required',
            'proddoc_description' => '',
        ]);
    }
}
