<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adresse extends Model
{

//    protected $fillable = [
//        'ad_name_kurz' ,
//        'ad_name_lang' ,
//        'ad_name_firma' ,
//        'ad_name_firma_2' ,
//        'ad_name_firma_co' ,
//        'ad_name_firma_abladestelle' ,
//        'ad_name_firma_wareneingang' ,
//        'ad_name_firma_abteilung' ,
//        'ad_anschrift_strasse' ,
//        'ad_anschrift_hausnummer' ,
//        'ad_anschrift_etage' ,
//        'ad_anschrift_eingang' ,
//        'ad_anschrift_plz' ,
//        'ad_anschrift_ort' ,
//        'address_type_id' ,
//        'land_id'
//    ];

use SoftDeletes;

    protected $guarded = [];

    public function search($term) {
        return Adresse::where('ad_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('ad_name_lang', 'like', '%' . $term . '%')
            ->orWhere('ad_name_firma', 'like', '%' . $term . '%')
            ->orWhere('ad_name_firma_2', 'like', '%' . $term . '%')
            ->orWhere('ad_name_firma_co', 'like', '%' . $term . '%')
            ->orWhere('ad_name_firma_abladestelle', 'like', '%' . $term . '%')
            ->orWhere('ad_name_firma_wareneingang', 'like', '%' . $term . '%')
            ->orWhere('ad_name_firma_abteilung', 'like', '%' . $term . '%')
            ->orWhere('ad_anschrift_strasse', 'like', '%' . $term . '%')
            ->orWhere('ad_anschrift_hausnummer', 'like', '%' . $term . '%')
            ->orWhere('ad_anschrift_etage', 'like', '%' . $term . '%')
            ->orWhere('ad_anschrift_eingang', 'like', '%' . $term . '%')
            ->orWhere('ad_anschrift_plz', 'like', '%' . $term . '%')
            ->orWhere('ad_anschrift_ort', 'like', '%' . $term . '%')
            ->get();
    }

    public function profile()
    {
        return $this->belongsTo(Location::class);
    }

    public function Location()
    {
        return $this->hasMany(Location::class);
    }

    public function AddressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function Firma() {
        return $this->hasOne(Firma::class);
    }
}
