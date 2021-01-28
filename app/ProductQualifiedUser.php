<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ProductQualifiedUser extends Model
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id',
        'produkt_id',
        'product_qualified_date',
        'product_qualified_firma',
    ];

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
