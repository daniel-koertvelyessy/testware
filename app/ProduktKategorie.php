<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduktKategorie extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Produkt()
    {
        return $this->hasMany(Produkt::class);
    }

    public function ProduktKategorieParam()
    {
        return $this->hasMany(ProduktKategorieParam::class);
    }

    public function apiAdd(Array $data)
        :int
    {
        if (ProduktKategorie::where('pk_label',$data['label'])->count() >0){
            return ProduktKategorie::where('pk_label',$data['label'])->first()->id;
        }
        $this->pk_label = $data['label'];
        $this->pk_name_nummer = $data['number'];
        $this->pk_name = $data['name'];
        $this->pk_description = $data['description'];
        $this->save();
        return $this->id;

    }

    public function apiCheck(int $id)
    :int
    {
        return (ProduktKategorie::where('id',$id)->count() >0) ? $id : 0;
    }

}
