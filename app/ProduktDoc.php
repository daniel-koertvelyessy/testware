<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProduktDoc extends Model
{
    /**
     * @var mixed|string
     */
    private $proddoc_name_lang;
    private $proddoc_name_pfad;
    private $document_type_id;
    private $produkt_id;
    private $proddoc_name_text;
    private $proddoc_name_kurz;

    public function produkt()
    {
        return $this->belongsTo(Produkt::class);
    }

    public function DocumentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function getSize($file) {
//        $size = Storage::zs
        return number_format(Storage::size($file) / 1028,1,',','.');
    }

    public function url($pfad) {
        return Storage::url($pfad);
    }

    public function getProdDokNum($produkt_id) {
        $ty = ProduktDoc::where('produkt_id',$produkt_id)->andWhere('document_type_id',1)->get();
    }
}

