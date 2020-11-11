<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentInstruction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'equipment_instruction_date',
        'equipment_instruction_instructor_signature',
        'equipment_instruction_instructor_profile_id',
        'equipment_instruction_instructor_firma_id',
        'equipment_instruction_trainee_signature',
        'equipment_instruction_trainee_id',
        'equipment_id',
    ];

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'equipment_instruction_trainee_id');
    }

}
