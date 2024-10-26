<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class ProductInstructedUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_instruction_date',
        'product_instruction_instructor_signature',
        'product_instruction_instructor_profile_id',
        'product_instruction_instructor_firma_id',
        'product_instruction_trainee_signature',
        'product_instruction_trainee_id',
        'produkt_id',
    ];


    public static function boot(): void
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::updating(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'product_instruction_trainee_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'product_instruction_trainee_id');
    }

    public function Firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class, 'product_instruction_firma_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Produkt::class);
    }
}
