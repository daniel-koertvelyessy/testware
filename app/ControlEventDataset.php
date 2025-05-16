<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ControlEventDataset extends Model
{
    use HasFactory;

    public function AciDataSet()
    {
        return $this->belongsTo(AciDataSet::class, 'aci_dataset_id');
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
