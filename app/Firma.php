<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Firma extends Model
{
    protected $guarded = [];

    use SoftDeletes;

    public function path()
    {
        return view('admin.firma.show', $this);
    }


    public function Adresse()
    {
        return $this->belongsTo(Adresse::class);
    }

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    public function produkt()
    {
        return $this->belongsToMany(Produkt::class);
    }

    public function getFirmaAdressData($aid) {
        return Adresse::find($aid)->first();
    }

    public function EquipmentFuntionControl()
    {
        return $this->hasMany(EquipmentFuntionControl::class);
    }

    public function addCompany(Request $request)
    {
        $request->validate([
            'fa_label' => 'required|max:20',
            'fa_name' => 'max:100',
            'fa_description' => '',
            'fa_kreditor_nr' => '',
            'fa_debitor_nr' => '',
            'fa_vat' => 'max:30',
            'adresse_id' => 'integer',
        ]);

        $this->fa_label = $request->fa_label;
        $this->fa_name = $request->fa_name;
        $this->fa_description = $request->fa_description;
        $this->fa_kreditor_nr = $request->fa_kreditor_nr;
        $this->fa_debitor_nr = $request->fa_debitor_nr;
        $this->fa_vat = $request->fa_vat;
        $this->adresse_id = isset($request->adresse_id) ? $request->adresse_id : 1;
        $this->save();

        return $this->id;




    }
}
