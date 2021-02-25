<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class ProductQualifiedUser extends Model
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id',
        'produkt_id',
        'product_qualified_date',
        'product_qualified_firma',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('system-status-counter');
        });
        static::updating(function () {
            Cache::forget('system-status-counter');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Produkt::class);
    }

    public function firma()
    {
        return $this->belongsTo(Firma::class, 'product_qualified_firma');
    }
}
