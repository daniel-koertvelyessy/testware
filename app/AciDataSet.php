<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AciDataSet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function controlEventDataSet()
    {
        return $this->hasMany(ControlEventDataset::class);
    }

    public function AnforderungControlItem()
    {
        return $this->belongsTo(AnforderungControlItem::class);
    }

    public function makeTolString(): string
    {

        if ($this->data_point_tol_target_mode === 'eq') {

            $tol = ($this->data_point_tol_mod === 'abs')
                ? $this->data_point_tol
                : $this->data_point_value * $this->data_point_tol / 100;

            return ' ± '.number_format($tol, 2).$this->AnforderungControlItem->aci_value_si;
        } elseif ($this->aci_value_target_mode === 'lt') {
            return __('Soll').' < '.__('Ist');
        } elseif ($this->aci_value_target_mode === 'gt') {
            return __('Soll').' > '.__('Ist');
        } else {
            return '-';
        }
    }

    public function valueString($value, $decimals = 2): string
    {

        if (Auth::user()->locale === 'de') {
            $thousands = '.';
            $dec = ',';
        } else {
            $thousands = "'";
            $dec = '.';
        }

        return number_format($value, $decimals, $dec, $thousands);
    }
}
