<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class EquipmentFuntionControl extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'function_control_date',
        'function_control_firma',
        'function_control_pass',
        'equipment_id',
    ];

    public function firma() {
        return $this->belongsTo(Firma::class,'function_control_firma');
    }

    public function addControlEvent(Request $request, $equipment_id)
    {
        if (
            !isset($equipment_id) ||
            ($request->function_control_firma === 'void' && $request->function_control_profil === 'void')
        ) return false;

        $this->controlled_at = $request->controlled_at;
        $this->function_control_firma = ($request->function_control_firma === 'void') ? NULL : $request->function_control_firma;
        $this->function_control_profil = ($request->function_control_profil === 'void') ? NULL : $request->function_control_profil;
        $this->function_control_pass = $request->function_control_pass;
        $this->equipment_id = $equipment_id;
        $this->save();

        $eh = new EquipmentHistory();
        $eh->eqh_eintrag_kurz = __('Funktionsprüfung erfolgt');
        $eh->eqh_eintrag_text = __('Das Geräte wurde am :date einer Funktionsprüfung unterzogen. ', ['date' => $request->controlled_at]);
        $eh->eqh_eintrag_text .= ($request->function_control_pass === '1') ? __('Die Prüfung wurde erfolgreich abgeschlossen.') : __(' Die Prüfung konnte nicht erfolgreich abgeschlossen werden. Gerät wird gesperrt');
        if ($request->function_control_text !== NULL) $eh->eqh_eintrag_text .= 'Bemerkungen: ' . $request->function_control_text;
        $eh->equipment_id = $equipment_id;
        $eh->save();

        return $this->id;
    }

}
