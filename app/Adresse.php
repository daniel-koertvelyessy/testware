<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Adresse extends Model
{

    //    protected $fillable = [
    //        'ad_label' ,
    //        'ad_name' ,
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

    public function search($term)
    {
        return Adresse::where('ad_label', 'like', '%' . $term . '%')
            ->orWhere('ad_name', 'like', '%' . $term . '%')
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

    public function Firma()
    {
        return $this->hasOne(Firma::class);
    }

    public function addAddress(Request $request, $model = false)
    {
        if (isset($request->address) && isset($request->address['label'])) {
            $request->validate([
                'address.label' => 'bail|required|unique:adresses,ad_label|max:20',
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
            $adresse->ad_label = $request->address['label'];
            $adresse->ad_anschrift_strasse = $request->address['street'];
            $adresse->ad_anschrift_hausnummer = $request->address['no'];
            $adresse->ad_anschrift_plz = $request->address['zip'];
            $adresse->ad_anschrift_ort = $request->address['city'];
            $adresse->land_id = (isset($request->address['country_id'])) ? $request->address['country_id'] :  1;

            if (isset($request->address['address_type']['name'])) {
                $st = AddressType::where('adt_name', $request->address['address_type'])->first();
                if (!$st) {
                    $address_type = new AddressType();
                    $address_type->adt_name = $request->address['address_type']['name'];
                    $address_type->adt_text_lang = (isset($request->address['address_type']['description'])) ? $request->address['address_type']['description'] : NULL;
                    $address_type->save();
                    $adresse->address_type_id = $address_type->id;
                } else {
                    $adresse->address_type_id = $st->id;
                }
            } elseif (isset($request->address['address_type_id'])) {
                $adresse->address_type_id = (AddressType::find($request->address['address_type_id'])) ? $request->address['address_type_id'] : 1;
            } else {
                $adresse->address_type_id = 1;
            }
            $adresse->save();
            return $model ? $adresse : $adresse->id;
        } elseif (isset($request->address_id)) {
            return (Adresse::find($request->address_id)) ? $request->address_id : NULL;
        } else {
            return NULL;
        }
    }

    public function addAddressArray($data)
    {
        if (isset($data) && isset($data['label'])) {
            $adresse = new Adresse();
            $adresse->ad_label = $data['label'];
            $adresse->ad_anschrift_strasse = $data['street'];
            $adresse->ad_anschrift_hausnummer = $data['no'];
            $adresse->ad_anschrift_plz = $data['zip'];
            $adresse->ad_anschrift_ort = $data['city'];
            $adresse->land_id = (isset($data['country_id'])) ? $data['country_id'] :  1;

            if (isset($data['address_type']['name'])) {
                $st = AddressType::where('adt_name', $data['address_type'])->first();
                if (!$st) {
                    $address_type = new AddressType();
                    $address_type->adt_name = $data['address_type']['name'];
                    $address_type->adt_text_lang = (isset($data['address_type']['description'])) ? $data['address_type']['description'] : NULL;
                    $address_type->save();
                    $adresse->address_type_id = $address_type->id;
                } else {
                    $adresse->address_type_id = $st->id;
                }
            } elseif (isset($data['address_type_id'])) {
                $adresse->address_type_id = (AddressType::find($data['address_type_id'])) ? $data['address_type_id'] : 1;
            } else {
                $adresse->address_type_id = 1;
            }
            $adresse->save();
            return $adresse->id;
        } elseif (isset($data['address_id'])) {
            return (Adresse::find($data['address_id'])) ? $data['address_id'] : NULL;
        } else {
            return NULL;
        }
    }

    public function postalAddress()
    {
        return  $this->ad_label  .': '.
                 $this->ad_anschrift_strasse . ' '.
                 $this->ad_anschrift_hausnummer. ' /  '  .
                 $this->ad_anschrift_plz . ' '.
                 $this->ad_anschrift_ort ;
    }
}
