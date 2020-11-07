<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProduktDoc extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    public function produkt()
    {
        return $this->belongsTo(Produkt::class);
    }

    public function DocumentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function getSize($file) {
        return helpers::fileSizeForHumans(Storage::size($file) );
    }

    public function url($pfad) {
        return Storage::url($pfad);
    }

    public function getProdDokNum($produkt_id) {
        $ty = ProduktDoc::where('produkt_id',$produkt_id)->andWhere('document_type_id',1)->get();
    }
}

