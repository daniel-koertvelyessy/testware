<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EquipmentQualifiedUser extends Model
{
    protected $fillable = [
        'user_id',
        'equipment_id',
        'equipment_qualified_date',
        'equipment_qualified_firma',
    ];

    use SoftDeletes;

    use Notifiable;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function firma() {
        return $this->belongsTo(Firma::class,'equipment_qualified_firma');
    }
}
