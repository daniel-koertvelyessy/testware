<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentParam extends Model
{
    public function addEquipmnt( $param_id, $param_value, $equipment_id )
    {
        $produktParam = ProduktParam::find($param_id);
        $this->ep_label = $produktParam->pp_label;
        $this->ep_name = $produktParam->ep_name;
        $this->ep_value = $param_value;
        $this->equipment_id = $equipment_id;
        $this->save();
    }
}
