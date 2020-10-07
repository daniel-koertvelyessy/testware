<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EquipmentDoc extends Model
{
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
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
}
