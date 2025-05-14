<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EquipmentFuntionControl extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'controlled_at',
        'function_control_firma',
        'function_control_profil',
        'function_control_pass',
        'function_control_text',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::updating(function () {
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
    }

    public function firma() {
        return $this->belongsTo(Firma::class,'function_control_firma');
    }

    public function addControlEvent(Request $request, $equipment_id)
    {

        if (
            !isset($equipment_id) ||
            ($request->function_control_firma === 'void' && $request->function_control_profil === 'void')
        ) return false;

        $this->controlled_at = $request->function_control_date??$request->controlled_at;
        $this->function_control_firma = ($request->function_control_firma === 'void') ? NULL : $request->function_control_firma;
        $this->function_control_profil = ($request->function_control_profil === 'void') ? NULL : $request->function_control_profil;
        $this->function_control_pass = $request->function_control_pass;
        $this->equipment_id = $equipment_id;
        $this->save();

        $eqh_eintrag_text = __('Das Geräte wurde am :date einer Funktionsprüfung unterzogen. ', ['date' => $request->function_control_date]);
        $eqh_eintrag_text .= ($request->function_control_pass === '1') ? __('Die Prüfung wurde erfolgreich abgeschlossen.') : __(' Die Prüfung konnte nicht erfolgreich abgeschlossen werden. Gerät wird gesperrt.');
        if ($request->function_control_text !== NULL) $eqh_eintrag_text .= __('Bemerkungen'). ': ' . $request->function_control_text;

        (new EquipmentHistory)->add(
            __('Funktionsprüfung erfolgt'),
            $eqh_eintrag_text,
            $equipment_id
        );

        return $this->id;
    }

}
