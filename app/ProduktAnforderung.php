<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class ProduktAnforderung extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::updating(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::deleting(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
    }

    public function Produkt()
    {
        return $this->belongsTo(Produkt::class);
    }

    public function Anforderung()
    {
        return $this->belongsTo(Anforderung::class);
    }

    public function AnforderungControlItem() {
        return $this->hasMany(AnforderungControlItem::class);
    }

    public function add($product_id, $requirement_id)
    {
        $this->produkt_id = $product_id;
        $this->anforderung_id = $requirement_id;
        return $this->save();
    }

}
