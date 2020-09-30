<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $guarded = [];

    public function ProduktDoc()
    {
        return $this->belongsTo(ProduktDoc::class);
    }


}
