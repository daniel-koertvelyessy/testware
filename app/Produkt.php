<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;

class Produkt extends Model
{
    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'prod_label',
        'prod_name',
        'prod_nummer',
        'prod_active',

    ];
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
            Cache::forget('system-status-counter');
        });
        static::updating(function () {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
            Cache::forget('system-status-counter');
        });
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

    public function ProductQualifiedUser()
    {
        return $this->hasMany(ProductQualifiedUser::class);
    }

    public function ProductInstructedUser()
    {
        return $this->hasMany(ProductInstructedUser::class);
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

    public function hasRequirement(Anforderung $requirement)
    {
        return ProduktAnforderung::where([
                [
                    'anforderung_id',
                    $requirement->id
                ],
                [
                    'produkt_id',
                    $this->id
                ],
            ])->count() > 0;
    }

    public function getEntry(array $data)
    {
        $product = Produkt::where([
            [
                'prod_label',
                $data['product_label']
            ],
            [
                'prod_nummer',
                $data['product_number']
            ],
        ])->first();
        return $product->id;
    }
}
