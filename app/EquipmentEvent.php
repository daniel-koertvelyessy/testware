<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class EquipmentEvent extends Model
{
    protected $fillable = [
        'equipment_event_text',
        'equipment_event_user',
        'equipment_id',
    ];

    use SoftDeletes, Notifiable, Sortable;

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'equipment_event_user',
        'equipment_event_text',
        'equipment_id',
        ];


    public function search($term) {
        return EquipmentEvent::whereRaw('lower(equipment_event_text) like ? ', '%' . strtolower($term) . '%')
            ->get();
    }

    public function User() {
        return $this->belongsTo(User::class, 'equipment_event_user');
    }

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function eventitems() {
        return $this->hasMany(EquipmentEventItem::class);
    }

}
