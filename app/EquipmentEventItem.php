<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EquipmentEventItem extends Model {
    protected $fillable = [
        'equipment_event_item_text',
        'user_id',
        'equipment_event_id',
    ];

    use SoftDeletes;

    use Notifiable;

    public function events() {
        return $this->belongsTo(EquipmentEvent::class);
    }

    public function search($term) {
        return EquipmentEventItem::where('equipment_event_item_text', 'like', '%' . $term . '%')
            ->get();
    }

}
