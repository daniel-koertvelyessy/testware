<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentHistory extends Model
{
    public function add($eqh_eintrag_kurz, $eqh_eintrag_text, $equipment_id)
    {
        $this->eqh_eintrag_kurz = $eqh_eintrag_kurz;
        $this->eqh_eintrag_text = $eqh_eintrag_text;
        $this->equipment_id = $equipment_id;
        $this->save();
    }
}
