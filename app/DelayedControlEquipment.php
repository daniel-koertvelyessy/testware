<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DelayedControlEquipment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function ControlEquipment()
    {
        return $this->hasMany(ControlEquipment::class);
    }

    /**
     * A delayed control event was spotted and will be reported
     *
     * @param  Equipment $equipment
     *
     * @return bool
     */
    public function reportEquipment(Equipment $equipment)
    : bool
    {
        $this->control_equipment_id = $equipment->id;
        return $this->save();
    }
}

