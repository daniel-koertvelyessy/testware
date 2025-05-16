<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlEventItem extends Model
{
    protected $guarded = [];

    //    protected $table = 'equipments';

    use SoftDeletes;

    public function ControlEvent()
    {
        return $this->belongsTo(ControlEvent::class);
    }

    public function ControlEquipment()
    {
        return $this->belongsTo(ControlEquipment::class);
    }

    public function AnforderungControlItems()
    {
        return $this->hasMany(AnforderungControlItem::class, 'id', 'control_item_aci');
    }

    public function AnforderungControlItem()
    {
        return $this->hasOne(AnforderungControlItem::class, 'id', 'control_item_aci');
    }
}
