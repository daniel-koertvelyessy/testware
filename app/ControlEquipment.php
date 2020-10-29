<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlEquipment extends Model {
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


    public function checkDueDate(ControlEquipment $qeitem) {
        $date = Carbon::parse($qeitem->qe_control_date_due)->DiffForHumans();
        if (now()->addWeeks($qeitem->qe_control_date_warn) < $qeitem->qe_control_date_due) {
            return '<span class="fas fa-circle text-success mr-3"></span> ' . $date;
        } elseif (now()->addWeeks($qeitem->qe_control_date_warn) >= $qeitem->qe_control_date_due && now() < $qeitem->qe_control_date_due) {
            return '<span class="fas fa-circle text-warning mr-3"></span> ' . $date;
        } else {
            return '<span class="fas fa-circle text-danger mr-3"></span> ' . $date;
        }

    }


}
