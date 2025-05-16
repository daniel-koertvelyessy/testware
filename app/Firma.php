<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Firma extends Model
{
    protected $fillable = [
        'fa_label',
        'fa_name',
        'fa_description',
        'fa_kreditor_nr',
        'fa_debitor_nr',
        'fa_vat',
        'adresse_id',
    ];

    use SoftDeletes;

    public function path()
    {
        return view('admin.organisation.firma.show', $this);
    }

    // TODO replace german method with en one below
    public function Adresse()
    {
        return $this->belongsTo(Adresse::class);
    }

    public static function getAddressLabel(Firma $firma): string
    {

        $address = Adresse::find($firma->adresse_id);

        return $address->ad_anschrift_strasse.' - '.$address->ad_anschrift_ort;

    }

    public function address()
    {
        return $this->belongsTo(Adresse::class);
    }

    public function equipmentInstructor()
    {
        return $this->hasMany(EquipmentInstruction::class, 'equipment_instruction_instructor_firma_id');
    }

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    public function produkt()
    {
        return $this->belongsToMany(Produkt::class);
    }

    public function getFirmaAdressData($aid)
    {
        return Adresse::find($aid)->first();
    }

    public function EquipmentFuntionControl()
    {
        return $this->hasMany(EquipmentFuntionControl::class);
    }

    public function updateCompany(Request $request, $returnModal = false)
    {
        $this->fa_label = $request->fa_label;
        $this->fa_name = $request->fa_name;
        $this->fa_description = $request->fa_description;
        $this->fa_kreditor_nr = $request->fa_kreditor_nr;
        $this->fa_debitor_nr = $request->fa_debitor_nr;
        $this->fa_vat = $request->fa_vat;
        $this->adresse_id = $request->adresse_id;

        return ($returnModal) ? $this : $this->save();
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
            'adresse_id' => '',
        ]);

        $this->fa_label = $request->fa_label;
        $this->fa_name = $request->fa_name;
        $this->fa_description = $request->fa_description;
        $this->fa_kreditor_nr = $request->fa_kreditor_nr;
        $this->fa_debitor_nr = $request->fa_debitor_nr;
        $this->fa_vat = $request->fa_vat;
        $this->adresse_id = isset($request->adresse_id) ? $request->adresse_id : null;
        $this->save();

        return $this->id;
    }

    public function addFromAPI(array $data, $addAddress = false)
    {
        if (empty($data['label'])) {
            return 0;
        }
        $this->fa_label = $data['label'];
        $this->fa_name = $data['name'];
        $this->fa_description = $data['description'];
        $this->fa_kreditor_nr = $data['vendor_id'];
        $this->fa_debitor_nr = $data['custmer_id'];
        $this->fa_vat = $data['vat'];
        if (isset($data['address']) && isset($data['address']['label']) && $addAddress) {
            $this->adresse_id = (new Adresse)->addFromAPI($data['address']);
        } else {
            $this->adresse_id = $data['address_id'] ?? 1;
        }

        return ($this->save()) ? $this->id : false;
    }

    public function getEntry(array $data)
    {
        if (isset($data['id'])) {
            $company = Firma::find($data['id']);

            return $company->id;
        }

        $getCompany = Firma::where([
            [
                'fa_label',
                $data['label'],
            ],
            [
                'fa_name',
                $data['name'],
            ],
        ])->first();

        return $getCompany->id;
    }
}
