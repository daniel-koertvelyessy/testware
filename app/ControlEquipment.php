<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class ControlEquipment extends Model
{

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function AnforderungControlItem() {
        return $this->belongsTo(AnforderungControlItem::class);
    }



    public function checkDueDate($qeitem) {

        if(date('Y-m-d',time()+ (60*60*24*7)*$qeitem->qe_control_date_warn) < $qeitem->qe_control_date_due)
        {
            return '<span class="fas fa-circle text-success"></span> '. $qeitem->qe_control_date_due ;
        } elseif ( date('Y-m-d',time()+ (60*60*24*7)*$qeitem->qe_control_date_warn) == $qeitem->qe_control_date_due )
        {
            return '<span class="fas fa-circle text-warning"></span> '. $qeitem->qe_control_date_due ;
        } else {
            return '<span class="fas fa-circle text-danger"></span> '. $qeitem->qe_control_date_due ;
        }

//        dump( date('Y-m-d',time()+ (60*60*24*7)*$qeitem->qe_control_date_warn) < $qeitem->qe_control_date_due) ;
//
//
//        dd($qeitem->AnforderungControlItem->Anforderung->ControlInterval->ci_delta);
    }

}
