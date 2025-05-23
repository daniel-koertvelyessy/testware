<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class EquipmentEventItem extends Model
{
    protected $fillable = [
        'equipment_event_item_text',
        'user_id',
        'equipment_event_id',
    ];

    use Notifiable, SoftDeletes;

    public function events()
    {
        return $this->belongsTo(EquipmentEvent::class);
    }

    public function addItem(Request $request)
    {
        $this->equipment_event_item_text = $request->equipment_event_item_text;
        $this->user_id = (isset($request->user_id)) ? $request->user_id : Auth()->user()->id;
        $this->equipment_event_id = $request->equipment_event_id;
        $this->save();

        return $this;
    }
}
