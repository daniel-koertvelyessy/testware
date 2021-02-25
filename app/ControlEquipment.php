<?php

namespace App;

use Carbon\Carbon;

//use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ControlEquipment extends Model
{
    use SoftDeletes, Sortable;

    public $sortable = [
        'id',
        'qe_control_date_due',
    ];

    public function Equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /*    public function Produkt()
        {
            return $this->hasOneThrough('App\Produkt','App\Equipment');
        }*/

    public function Anforderung()
    {
        return $this->belongsTo(Anforderung::class);
    }

    public function checkDueDateIcon(ControlEquipment $qeitem)
    {
        if (now()->addWeeks($qeitem->qe_control_date_warn) < $qeitem->qe_control_date_due) {
            return '<span class="fas fa-circle text-success mr-3"></span> ';
        } elseif (now()->addWeeks($qeitem->qe_control_date_warn) >= $qeitem->qe_control_date_due && now() < $qeitem->qe_control_date_due) {
            return '<span class="fas fa-circle text-warning mr-3"></span> ';
        } else {
            return '<span class="fas fa-circle text-danger mr-3"></span> ';
        }

    }

    public function checkDueDate(ControlEquipment $qeitem)
    {
        $date = Carbon::parse($qeitem->qe_control_date_due)->DiffForHumans();
        if (now()->addWeeks($qeitem->qe_control_date_warn) < $qeitem->qe_control_date_due) {
            return '<span class="fas fa-circle text-success mr-3"></span> ' . $date;
        } elseif (now()->addWeeks($qeitem->qe_control_date_warn) >= $qeitem->qe_control_date_due && now() < $qeitem->qe_control_date_due) {
            return '<span class="fas fa-circle text-warning mr-3"></span> ' . $date;
        } else {
            return '<span class="fas fa-circle text-danger mr-3"></span> ' . $date;
        }

    }

    public function checkControlRequirementsMet()
    {
        $controlItemMsg = '';
        $hasQualifiedUsersMsg = '';
        $hasTestItemMsg = '';

        $hasControlItems = 0;
        if ($this->countControlItems() > 0) {
            $hasControlItems = $this->countControlItems();
        } else {
            $controlItemMsg = '<span class="bg-warning p-1">' . __('Keine Kontrollvorgänge gefunden!') . ' </span><a href="' . route('anforderungcontrolitem.create', ['anforderung_id' => $this->Anforderung->id]) . '" class="btn btn-sm btn-outline-primary ml-2">' . __('Beheben') . '</a>';
        }

        $hasQualifiedUsers = 0;
        if ($this->countQualifiedUser() > 0) {
            $hasQualifiedUsers = $this->countQualifiedUser();
        } else {
            $hasQualifiedUsersMsg = '<span class="bg-warning p-1">' . __('Keine befähigte Person gefunden!') . '</span>';
        }

        $hasTestItem = false;
        $countControlProducts = ControlProdukt::all()->count();
        foreach ($this->Anforderung->AnforderungControlItem as $aci) {
            if ($aci->aci_control_equipment_required === 1) {
                if ($countControlProducts === 0) {
                    $hasTestItem = true;
                    $hasTestItemMsg = '<span class="bg-warning p-1">' . __('Keine Prüfmittel vorhanden!') . '</span><a href="' . route('produkt.index') . '" class="btn btn-sm btn-outline-primary ml-2">' . __('Beheben') . '</a>';
                }
            }
        }

        if ($hasControlItems > 0 && $hasQualifiedUsers > 0 && !$hasTestItem) {
            return null;
        } else {
            return $controlItemMsg . $hasQualifiedUsersMsg . $hasTestItemMsg;
        }


    }

    public function countControlItems()
    {
        return $this->Anforderung->AnforderungControlItem->count();
    }

    public function countQualifiedUser()
    {
        $qualifiedUser = 0;
        $qualifiedUser += $this->Equipment->produkt->ProductQualifiedUser()->count();
        $qualifiedUser += $this->Equipment->countQualifiedUser();

        return $qualifiedUser;
    }

    public function addEquipment(ProduktAnforderung $produktAnforderung, $equipmemt_id, $lastDate)
    {

        $interval = $produktAnforderung->Anforderung->an_control_interval;
        $conInt = $produktAnforderung->Anforderung->control_interval_id;
        $zeit = ControlInterval::find($conInt);
        $dueDate = date('Y-m-d', strtotime("+" . $interval . $zeit->ci_delta, strtotime($lastDate)));
        $this->qe_control_date_last = $lastDate;
        $this->qe_control_date_due = $dueDate;
        $this->anforderung_id = $produktAnforderung->anforderung_id;
        $this->equipment_id = $equipmemt_id;
        $this->save();

        return $dueDate;
    }

}
