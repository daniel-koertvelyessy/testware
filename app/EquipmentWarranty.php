<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentWarranty extends Model
{
    public function addEquipment($warranty_expires_at, $equipment_id)
    {
        $this->expires_at = $warranty_expires_at;
        $this->equipment_id = $equipment_id;
        $this->save();
    }
}
