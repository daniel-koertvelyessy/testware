<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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

    public function addAddress(Request $request) {
        if (isset($request->address) && isset($request->address['identifier'])){
            $request->validate([
                'address.identifier' => 'bail|required|unique:adresses,ad_name_kurz|max:20',
                'address.name' => 'max:100',
                'address.company' => 'max:100',
                'address.company_2' => 'max:100',
                'address.company_co' => 'max:100',
                'address.company_unloading_point' => 'max:100',
                'address.company_goods_income' => 'max:100',
                'address.company_division' => 'max:100',
                'address.street' => 'max:100',
                'address.no' => 'required|max:100',
                'address.zip' => 'required|max:100',
                'address.city' => 'required|max:100',
                'address.floor' => 'max:100',
                'address.enterance' => 'max:100',
            ]);
            $adresse = new Adresse();
            $adresse->ad_name_kurz = $request->address['identifier'];
            $adresse->ad_anschrift_strasse = $request->address['street'];
            $adresse->ad_anschrift_hausnummer = $request->address['no'];
            $adresse->ad_anschrift_plz = $request->address['zip'];
            $adresse->ad_anschrift_ort = $request->address['city'];
            $adresse->land_id = (isset($request->address['country_id'])) ? $request->address['country_id'] :  1;

            if (isset($request->address['address_type']['name'])){
                $st = AddressType::where('adt_name',$request->address['address_type'])->first();
                if (!$st){
                    $address_type = new AddressType();
                    $address_type->adt_name = $request->address['address_type']['name'];
                    $address_type->adt_text_lang = (isset($request->address['address_type']['description'])) ? $request->address['address_type']['description'] : NULL;
                    $address_type->save();
                    $adresse->address_type_id = $address_type->id;
                } else{
                    $adresse->address_type_id = $st->id;
                }

            } elseif (isset($request->address['address_type_id'])){
                $adresse->address_type_id = (AddressType::find($request->address['address_type_id'])) ? $request->address['address_type_id'] : 1 ;
            } else {
                $adresse->address_type_id = 1;
            }
            $adresse->save();
            return $adresse->id;
        } elseif (isset($request->address_id)){
            return (Adresse::find($request->address_id)) ? $request->address_id : NULL;
        } else {
            return NULL;
        }
    }

}
