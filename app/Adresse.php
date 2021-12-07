<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        return Adresse::where('ad_label', 'like', '%' . $term . '%')->orWhere('ad_name', 'like', '%' . $term . '%')->orWhere('ad_name_firma', 'like', '%' . $term . '%')->orWhere('ad_name_firma_2', 'like', '%' . $term . '%')->orWhere('ad_name_firma_co', 'like', '%' . $term . '%')->orWhere('ad_name_firma_abladestelle', 'like', '%' . $term . '%')->orWhere('ad_name_firma_wareneingang', 'like', '%' . $term . '%')->orWhere('ad_name_firma_abteilung', 'like', '%' . $term . '%')->orWhere('ad_anschrift_strasse', 'like', '%' . $term . '%')->orWhere('ad_anschrift_hausnummer', 'like', '%' . $term . '%')->orWhere('ad_anschrift_etage', 'like', '%' . $term . '%')->orWhere('ad_anschrift_eingang', 'like', '%' . $term . '%')->orWhere('ad_anschrift_plz', 'like', '%' . $term . '%')->orWhere('ad_anschrift_ort', 'like', '%' . $term . '%')->get();
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

    public function country()
    {
        return $this->belongsTo(Land::class);
    }

    public function Firma()
    {
        return $this->hasOne(Firma::class);
    }

    public function addLocationAddress(Request $request, $model = false)
    {
        if (isset($request->address) && isset($request->address['label'])) {
            $request->validate([
                'address.label'                   => 'bail|required|unique:adresses,ad_label|max:20',
                'address.name'                    => 'max:100',
                'address.company'                 => 'max:100',
                'address.company_2'               => 'max:100',
                'address.company_co'              => 'max:100',
                'address.company_unloading_point' => 'max:100',
                'address.company_goods_income'    => 'max:100',
                'address.company_division'        => 'max:100',
                'address.street'                  => 'max:100',
                'address.no'                      => 'required|max:100',
                'address.zip'                     => 'required|max:100',
                'address.city'                    => 'required|max:100',
                'address.floor'                   => 'max:100',
                'address.enterance'               => 'max:100',
            ]);
            $adresse = new Adresse();
            $adresse->ad_label = $request->address['label'];
            $adresse->ad_anschrift_strasse = $request->address['street'];
            $adresse->ad_anschrift_hausnummer = $request->address['no'];
            $adresse->ad_anschrift_plz = $request->address['zip'];
            $adresse->ad_anschrift_ort = $request->address['city'];
            $adresse->land_id = (isset($request->address['country_id'])) ? $request->address['country_id'] : 1;

            if (isset($request->address['address_type']['name'])) {
                $st = AddressType::where('adt_name', $request->address['address_type'])->first();
                if (!$st) {
                    $address_type = new AddressType();
                    $address_type->adt_name = $request->address['address_type']['name'];
                    $address_type->adt_text_lang = (isset($request->address['address_type']['description'])) ? $request->address['address_type']['description'] : null;
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
            return (Adresse::find($request->address_id)) ? $request->address_id : null;
        } else {
            return null;
        }
    }

    public function fullAddress(Adresse $adresse){
        return [
            'street' => $adresse->ad_anschrift_strasse . ' ' . $adresse->ad_anschrift_hausnummer,
            'city' => $adresse->ad_anschrift_plz . ' ' . $adresse->ad_anschrift_ort,
            'country' => $adresse->country->land_lang
            ];
    }

    /**
     * @param  array $data
     * @param  bool  $addCompanyData
     *
     * @return mixed|null
     */
    public function addFromAPI(array $data, bool $addCompanyData = true)
    {
        $address = Adresse::where('ad_label', $data['label']);
        if ($address->count() > 0) return $address->first()->id;

        if (isset($data['label'])) {
            $adresse = new Adresse();
            $adresse->ad_label = $this->encUft($data['label']);
            $adresse->ad_name = $this->encUft($data['name']);
            $adresse->ad_name_firma = $this->encUft($data['company']);
            $adresse->ad_name_firma_2 = $this->encUft($data['company_2']) ?? null;
            $adresse->ad_name_firma_co = $this->encUft($data['company_co']) ?? null;
            $adresse->ad_name_firma_abladestelle = $this->encUft($data['company_unloading_point']) ?? null;
            $adresse->ad_anschrift_strasse = $this->encUft($data['street']);
            $adresse->ad_anschrift_hausnummer = $this->encUft($data['no']);
            $adresse->ad_anschrift_plz = $this->encUft($data['zip']);
            $adresse->ad_anschrift_ort = $this->encUft($data['city']);
            $adresse->land_id = (isset($data['country_id'])) ? $data['country_id'] : 1;

            /**
             * Check if address-type or respective id is given
             */
            if (isset($data['address_type']['name'])) {
                $existingAddress = AddressType::where('adt_name', $data['address_type'])->first();
                if (!$existingAddress) {
                    $address_type = new AddressType();
                    $address_type->adt_name = $this->encUft($data['address_type']['name']);
                    $address_type->adt_text_lang = (isset($data['address_type']['description'])) ? $this->encUft($data['address_type']['description']) : null;
                    $address_type->save();
                    $adresse->address_type_id = $address_type->id;
                } else {
                    $adresse->address_type_id = $existingAddress->id;
                }
            } elseif (isset($data['address_type_id'])) {
                $adresse->address_type_id = (AddressType::find($data['address_type_id'])) ? $data['address_type_id'] : 1;
            } else {
                $adresse->address_type_id = 1;
            }
            $adresse->save();

            if ($addCompanyData) {
                /**
                 * check if company exists and add if not
                 */
                $existingCompany = Firma::where([
                    [
                        'fa_name',
                        $data['company']
                    ],
                    [
                        'adresse_id',
                        $adresse->id
                    ],
                ])->first();
                if (!$existingCompany) {
                    $company = new Firma();
                    $label = mb_strtolower(substr( 'co_API_'.$adresse->id. '_' . preg_replace('/\s/', '_',$this->encUft($data['company'])), 0, 20));
                    echo 'new label => '. $label . "\n";
                    $company->fa_label = $label;
                    $company->fa_name = $this->encUft($data['company']);
                    $company->fa_description = "Generated by API during creation of address " . $this->encUft($data['label']);
                    $company->adresse_id = $adresse->id;
                    $company->save();
                }
            }

            return $adresse->id;
        } elseif (isset($data['address_id'])) {
            return (Adresse::find($data['address_id'])) ? $data['address_id'] : null;
        } else {
            return null;
        }
    }

    public function postalAddress()
    {
        return $this->ad_label . ': ' . $this->ad_anschrift_strasse . ' ' . $this->ad_anschrift_hausnummer . ' /  ' . $this->ad_anschrift_plz . ' ' . $this->ad_anschrift_ort;
    }

    public function addNew(Request $request, $returnModel = false)
    {
        $this->ad_label = $request->ad_label;
        $this->address_type_id = $request->address_type_id;
        $this->ad_name = $request->ad_name;
        $this->ad_anschrift_strasse = $request->ad_anschrift_strasse;
        $this->ad_anschrift_hausnummer = $request->ad_anschrift_hausnummer;
        $this->ad_anschrift_ort = $request->ad_anschrift_ort;
        $this->ad_anschrift_plz = $request->ad_anschrift_plz;
        $this->land_id = $request->land_id;
        $this->ad_name_firma = $request->ad_name_firma;
        $checkStatus = $this->save();
        return ($returnModel) ? $checkStatus : $this->id;
    }


    public function updateAddress(Request $request): ?Adresse
    {
        if (isset($request->address_id)) {
            $address = Adresse::find($request->address_id);
            $address->ad_label = $request->ad_label;
            $address->address_type_id = $request->address_type_id;
            $address->ad_name = $request->ad_name;
            $address->ad_anschrift_strasse = $request->ad_anschrift_strasse;
            $address->ad_anschrift_hausnummer = $request->ad_anschrift_hausnummer;
            $address->ad_anschrift_ort = $request->ad_anschrift_ort;
            $address->ad_anschrift_plz = $request->ad_anschrift_plz;
            $address->land_id = $request->land_id;
            $address->ad_name_firma = $request->ad_name_firma;
            return $address;
        } else {
            return null;
        }


    }



    /**
     * @return array
     */
    public function validateAdresse()
    : array
    {
        return request()->validate([
            'ad_label'             => [
                'bail',
                'max:20',
                'required',
                Rule::unique('address')->ignore(\request('id'))
            ],
            'ad_anschrift_strasse' => 'required',
            'ad_anschrift_plz'     => 'required',
            'ad_anschrift_ort'     => 'required'
        ]);
    }

    public function encUft($string)
    {
       return (is_null($string)) ? NULL : mb_convert_encoding($string,'UTF-8',mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15, ASCII"));
    }
}
