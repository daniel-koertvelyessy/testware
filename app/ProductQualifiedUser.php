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
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::updating(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
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

    public function addApi(array $data)
    {
        $this->product_qualified_firma = $data['product_qualified_firma'];
        $this->product_qualified_date = $data['product_qualified_date'];
        $this->user_id = $data['user_id'];
        $this->produkt_id = $data['produkt_id'];
        return $this->save();
    }

    public function checkEntry(array $array)
    {
        $company_id = (new Firma)->getEntry($array['company']);
        $employee_id = (new Profile)->getEntry($array['employee']);
        $produkt_id = (new Produkt)->getEntry([
            'product_label' => $array['product_label'],
            'product_number' => $array['product_number'],
        ]);


        return ProductQualifiedUser::where([
                [
                    'produkt_id',
                    $produkt_id
                ],
                [
                    'product_qualified_date',
                    $array['qualified_at']
                ],
                [
                    'product_qualified_firma',
                    $company_id
                ],
                [
                    'user_id',
                    $employee_id
                ],
            ])->count() > 0;

    }
}
