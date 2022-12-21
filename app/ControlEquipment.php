<?php

namespace App;

use Carbon\Carbon;

//use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Http\Request;

class ControlEquipment extends Model
{
    use SoftDeletes, Sortable;

    protected $guarded= [];

    public $sortable = [
        'id',
        'qe_control_date_due',
    ];

    public function Equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function DelayedControlEquipment()
    {
        return $this->belongsTo(DelayedControlEquipment::class);
    }

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
            return '<span class="fas fa-circle text-success mr-3"></span> ' . '<span class="d-none d-md-inline">' . $date . '</span>';
        } elseif (now()->addWeeks($qeitem->qe_control_date_warn) >= $qeitem->qe_control_date_due && now() < $qeitem->qe_control_date_due) {
            return '<span class="fas fa-circle text-warning mr-3"></span> ' . '<span class="d-none d-md-inline">' . $date . '</span>';
        } else {
            return '<span class="fas fa-circle text-danger mr-3"></span> ' . '<span class="d-none d-md-inline">' . $date . '</span>';
        }

    }

    public function checkControlRequirementsMet()
    {
        $controlItemMsg = '';
        $hasQualifiedUsersMsg = '';
        $hasTestItemMsg = '';
        $hasControlItems = 0;

        $Anforderung = Anforderung::find($this->anforderungs_id);

        if (!$Anforderung){
            return [
                'success' => false,
                'html'    => $this->makeHtmlWarning(__('Keine Anforderung mit Gerät verknüpft'),'#')
            ];
        }

        if ($this->countControlItems($Anforderung) > 0) {
            $hasControlItems = $this->countControlItems($Anforderung);
        } else {
            $controlItemMsg = $this->makeHtmlWarning(__('Keine Prüfschritte gefunden!'), route('anforderungcontrolitem.create', ['anforderung_id' => $Anforderung->id]));

        }

        $hasQualifiedUsers = 0;
        if ($this->countQualifiedUser() > 0) {
            $hasQualifiedUsers = $this->countQualifiedUser();
        } else {
            $hasQualifiedUsersMsg = $this->makeHtmlWarning(__('Keine befähigte Person gefunden!'), route('produkt.index'));
        }

        $testProductsAvaliable = true;
        $hasTestItem = false;
        $controlProductsAvaliable = ControlProdukt::all()->count();

        $countControlEquipment = Equipment::getControlEquipmentList();


        foreach ($Anforderung->AnforderungControlItem as $aci) {
            $hasTestItem = true;
            if ($aci->aci_control_equipment_required) {
                if ($countControlEquipment->count() == 0) {
                    $testProductsAvaliable = false;
                    $hasTestItemMsg = $this->makeHtmlWarning(__('Keine Prüfmittel vorhanden!'), route('produkt.index'));
                }
            }
        }

//        dump('countControlItems => ' . $this->countControlItems());
//        dump('countQualifiedUser => ' . $this->countQualifiedUser());
//        dump('$testProductsAvaliable => ', $testProductsAvaliable);
//        dump('$hasTestItem => ', $hasTestItem);
//        dump('$controlProductsAvaliable => ' . $controlProductsAvaliable);
//        dump('$testProductsAvaliable => ', $testProductsAvaliable);
//
//        dd($hasControlItems > 0 && $hasQualifiedUsers > 0 && ($hasTestItem && $testProductsAvaliable));


        if ($hasControlItems > 0 && $hasQualifiedUsers > 0 && ($hasTestItem && $testProductsAvaliable)) {
            return [
                'success' => true,
                'html'    => null
            ];
        } else {
            return [
                'success' => false,
                'html'    => $controlItemMsg . $hasQualifiedUsersMsg . $hasTestItemMsg
            ];
        }

    }

    public function countControlItems(Anforderung $anforderung)
    {

        return ($anforderung) ? $anforderung->AnforderungControlItem->count() : -1;
    }

    public function makeHtmlWarning($msg, $link)
    {
        return '<span class="bg-warning p-1">' . $msg . '</span><a href="' . $link . '" class="btn btn-sm btn-outline-primary ml-2">' . __('Beheben') . '</a>';
    }

    public function countQualifiedUser()
    {

        $qualifiedUser = 0;
        $qualifiedUser += $this->Equipment->produkt->ProductQualifiedUser()->count();
        $qualifiedUser += $this->Equipment->countQualifiedUser();

        return $qualifiedUser;
    }

    public function addEquipment(ProduktAnforderung $produktAnforderung, $equipmemt_id, Request $request)
    {

        $interval = $produktAnforderung->Anforderung->an_control_interval;
        $conInt = $produktAnforderung->Anforderung->control_interval_id;
        $zeit = ControlInterval::find($conInt);
        $dueDate = date('Y-m-d', strtotime("+" . $interval . $zeit->ci_delta, strtotime($request->qe_control_date_last)));
        $this->qe_control_date_last = $request->qe_control_date_last;
        $this->qe_control_date_due = $dueDate;
        $this->qe_control_date_warn = $request->qe_control_date_warn;
        $this->control_interval_id = $request->control_interval_id;
        $this->anforderung_id = $produktAnforderung->anforderung_id;
        $this->equipment_id = $equipmemt_id;
        $this->save();

        return $dueDate;
    }

}
