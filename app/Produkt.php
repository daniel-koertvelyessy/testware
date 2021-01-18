<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Produkt extends Model
{
    use SoftDeletes, Sortable;

    protected $guarded = [];

    public $sortable = [
        'id',
        'prod_label',
        'prod_name',
        'prod_nummer',
        'prod_active',

    ];

    public function search($term)
    {
        return Produkt::where('prod_label', 'like', '%' . $term . '%')
            ->orWhere('prod_name', 'like', '%' . $term . '%')
            ->orWhere('prod_description', 'like', '%' . $term . '%')
            ->orWhere('prod_nummer', 'like', '%' . $term . '%')
            ->get();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'prod_nummer';
    }

    public function ProduktKategorie()
    {
        return $this->belongsTo(ProduktKategorie::class);
    }

    public function ProduktDoc()
    {
        return $this->hasMany(ProduktDoc::class);
    }

    public function ProduktState()
    {
        return $this->belongsTo(ProduktState::class);
    }

    public function path()
    {
        return route('produkt.show', $this);
    }

    public function ProduktParam()
    {
        return $this->hasMany(ProduktParam::class);
    }

    public function ProduktAnforderung()
    {
        return $this->hasMany(ProduktAnforderung::class);
    }

    public function firma()
    {
        return $this->belongsToMany(Firma::class);
    }

    public function ControlProdukt()
    {
        return $this->hasOne(ControlProdukt::class);
    }

    public function Equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function EquipmentDetails()
    {
        return $this->hasOne(Equipment::class);
    }
}
