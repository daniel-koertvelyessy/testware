<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Kyslik\ColumnSortable\Sortable;

class AnforderungControlItem extends Model
{

    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
        'aci_label',
        'aci_name',
        'aci_task',
        'aci_sort',
    ];

    protected $guarded = [];

    protected $casts = [
        'aci_control_equipment_required' => 'boolean',
        'aci_execution'                  => 'boolean',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function Anforderung()
    {
        return $this->belongsTo(Anforderung::class);
    }

    public function ControlEquipment()
    {
        return $this->belongsTo(ControlEquipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'aci_contact_id');
    }

    public function firma()
    {
        return $this->belongsTo(Firma::class);
    }

    public function AciDataSet()
    {
        return $this->hasMany(AciDataSet::class);
    }

    public function isIncomplete(AnforderungControlItem $anforderungControlItem)
    {
        $isInComplete = false;
        $msgPG = '';
        $msgTo = '';
        if ($anforderungControlItem->aci_control_equipment_required === 1) {

            if (ControlProdukt::all()->count() === 0) {
                $msgPG = '<li>' . __('Kein Prüfgerät vorhanden!') . '</li>';
                $isInComplete = true;
            }
        }

        if ($anforderungControlItem->aci_value_target_mode === 'eq') {
            if ($anforderungControlItem->aci_value_tol === '' || $anforderungControlItem->aci_value_tol_mod === '')
                $msgTo = '<li>' . __('Toleranzangaben sind unvollständig') . '</li>';
            $isInComplete = true;
        }
        return ($isInComplete)
            ? $msgPG . $msgTo
            : false;
    }


    public function add(Request $request)
    {

        $this->aci_sort = $request->aci_sort;
        $this->aci_label = $request->aci_label;
        $this->aci_name = $request->aci_name;
        $this->aci_task = $request->aci_task;
        $this->aci_value_si = $request->aci_value_si;
        $this->aci_vaule_soll = $request->aci_vaule_soll;
        $this->aci_value_target_mode = $request->aci_value_target_mode;
        $this->aci_value_tol = $request->aci_value_tol;
        $this->aci_value_tol_mod = $request->aci_value_tol_mod;
        $this->aci_execution = ($request->aci_execution === "0");
        $this->aci_control_equipment_required = isset($request->aci_control_equipment_required);
        $this->firma_id = ($request->aci_execution === "0")
            ? NULL
            : $request->firma_id;
        $this->aci_contact_id = $request->aci_contact_id;
        $this->anforderung_id = $request->anforderung_id;
        return ($this->save())
            ? $this->id
            : false;
    }

    public function makeTolString(): string
    {
        if ($this->aci_value_target_mode === 'eq') {

            $tol = ($this->aci_value_tol_mod === 'abs')
                ? $this->aci_value_tol
                : $this->aci_vaule_soll * $this->aci_value_tol / 100;

            return __('Soll') . '=' . __('Ist') . "± $tol $this->aci_value_si";
        } elseif ($this->aci_value_target_mode === 'lt') {
            return __('Soll') . ' < ' . __('Ist');
        } elseif ($this->aci_value_target_mode === 'gt') {
            return __('Soll') . ' > ' . __('Ist');
        } else {
            return '-';
        }
    }

}
