<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EquipmentEvent extends Model
{
    protected $fillable = [
        'equipment_event_text',
        'equipment_event_user',
        'equipment_id',
    ];

    use SoftDeletes;

    use Notifiable;

    public function User() {
        return $this->belongsTo(User::class);
    }

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function eventitems() {
        return $this->hasMany(EquipmentEventItem::class);
    }

}
