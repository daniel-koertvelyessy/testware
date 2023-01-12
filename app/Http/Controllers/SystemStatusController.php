<?php

namespace App\Http\Controllers;

use App\Anforderung;
use App\AnforderungControlItem;
use App\ControlEquipment;
use App\ControlProdukt;
use App\Equipment;
use App\EquipmentFuntionControl;
use App\EquipmentQualifiedUser;
use App\EquipmentUid;
use App\ProductQualifiedUser;
use App\Produkt;
use App\Storage;
use App\Verordnung;
use Cache;

class SystemStatusController  extends Controller
{

    public function getBrockenEquipmentUuids()
    {

        $counter = Equipment::withTrashed()->get()->map(function (Equipment $equipment){
            return EquipmentUid::where('equipment_uid', $equipment->eq_uid)->count()==0 ? 1:0;
        });
        
        return $counter->sum();
    }

    public function getBrokenControlEquipmentItems()
    {
        /**
         * get all broken entries for equipment control
         */
        $counter = 0;
        $totalControlEquipment = ControlEquipment::withTrashed()->count();
        foreach(Anforderung::onlyTrashed()->get() as $anforderung){
            $count = ControlEquipment::withTrashed()->where('anforderung_id',$anforderung->id)->count();
            $counter += $count;
        }

        $brokenEquipmentControl = $counter >0;
        return [
            'totalControlEquipment'=> $totalControlEquipment,
            'brokenControlEquipment'=> $brokenEquipmentControl,
            'brokenControlEquipmenCount'=> $counter,
        ];
    }

    public function getBrokenProductItems()
    {
        return Produkt::withTrashed()->where('prod_uuid',null)->count();
    }

    public function getBrokenDBLinks()
    {
        $brokenLinksCount = 0;
        $brokenEquipmentControl = $this->getBrokenControlEquipmentItems();
        $brokenProducts = $this->getBrokenProductItems();
        $brokenLinksCount += $brokenEquipmentControl['brokenControlEquipmenCount'];


        //       return Cache::remember('system-status-counter', now()->addSeconds(10), function () use ($brokenEquipmentControl, $counter){
        return [
            'missingEquipmentUuids' => $this->getBrockenEquipmentUuids(),
            'brokenProducts' => $brokenProducts,
            'totalBrokenLinks' => $brokenLinksCount,
            'equipmentControl' => $brokenEquipmentControl
        ];
        //       });



    }

    public function getObjectStatus(): array
    {

        return Cache::remember('system-status-counter', now()->addSeconds(10), function ()  {
            $incomplete_equipment = false;
            $incomplete_requirement = 0;
            foreach (Anforderung::all() as $requirement) {
                $incomplete_requirement += $requirement->AnforderungControlItem()->count() > 0 ? 0 : 1;
            }

            $equipment = Equipment::all();
            $countEquipment = $equipment->count();
            foreach ($equipment as $item) {
                $incomplete_equipment += ControlEquipment::select('id')->where('equipment_id',$item->id)->count() === 0 ? 1:0;
            }

            $countControlEquipment = Equipment::with('produkt')->get()->map(function ($value) {
                return $value->produkt->ControlProdukt != null;
            })->sum();

            $countProducts = Produkt::all()->count();
            return [
                'products'                 => $countProducts,
                'equipment'                => $countEquipment,
                'control_products'         => ControlProdukt::all()->count(),
                'control_equipment'        => $countControlEquipment,
                'storages'                 => Storage::all()->count(),
                'equipment_qualified_user' => EquipmentQualifiedUser::all()->count(),
                'product_qualified_user'   => ProductQualifiedUser::all()->count(),
                'regulations'              => Verordnung::all()->count(),
                'requirements'             => Anforderung::all()->count(),
                'incomplete_requirement'   => $incomplete_requirement,
                'incomplete_equipment'     => $incomplete_equipment,
                'requirements_items'       => AnforderungControlItem::all()->count(),
            ];
        });

    }


}