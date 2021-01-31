<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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


    public function user()
    {
        return $this->belongsTo(User::class, 'product_instruction_trainee_id');
    }

    public function product()
    {
        return $this->belongsTo(Produkt::class);
    }
}
