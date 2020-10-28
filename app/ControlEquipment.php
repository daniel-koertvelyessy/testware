<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlEquipment extends Model
{
    use SoftDeletes;

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function Anforderung() {
        return $this->belongsTo(Anforderung::class);
    }

    public function ControlEvent() {
        return $this->hasMany(ControlEvent::class);
    }


    public function checkDueDate($qeitem) {

        if(now()->addWeeks($qeitem->qe_control_date_warn) < $qeitem->qe_control_date_due)
        {
            return '<span class="fas fa-circle text-success"></span> '. $qeitem->qe_control_date_due ;
        } elseif ( now()->addWeeks($qeitem->qe_control_date_warn) >= $qeitem->qe_control_date_due && now()<$qeitem->qe_control_date_due)
        {
            return '<span class="fas fa-circle text-warning"></span> '. $qeitem->qe_control_date_due ;
        } else {
            return '<span class="fas fa-circle text-danger"></span> '. $qeitem->qe_control_date_due ;
        }

    }



}
