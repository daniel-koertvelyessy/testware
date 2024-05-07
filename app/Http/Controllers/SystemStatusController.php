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
use App\Http\Services\Equipment\EquipmentEventService;
use App\ProductQualifiedUser;
use App\Produkt;
use App\ProduktAnforderung;
use App\Storage;
use App\Verordnung;
use Cache;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;
use function PHPUnit\Framework\isType;

class SystemStatusController extends Controller
{

    public function countOrphanEquipmentUids()
    {


        $counter = EquipmentUid::with('Equipment')->select('equipment_uid', 'equipment_id')->get()->filter(function ($equipmenetUid) {
            if ($equipmenetUid->Equipment) {
                return $equipmenetUid->Equipment->where('eq_uid', $equipmenetUid->equipment_uid)->count() > 1
                    ? 1
                    : 0;
            }
        });

        return $counter->sum();

    }

    public function getBrockenEquipmentUuids()
    {

        $counter = Equipment::withTrashed()->get()->map(function (Equipment $equipment) {
            return EquipmentUid::where('equipment_uid', $equipment->eq_uid)->count() == 0
                ? 1
                : 0;
        });

        return $counter->sum();
    }

    public function getDuplicateUuIds()
    {

        $allEquipUid = Equipment::select('id', 'eq_uid', 'eq_name', 'eq_inventar_nr', 'created_at')->get();

        $groupEqUid = $allEquipUid->groupBy('eq_uid');

        $grpList = $allEquipUid->filter(function ($equipment) {
            if (Equipment::where('eq_uid', $equipment->eq_uid)->count() > 1) {
                return $equipment;
            }
        });

        return [
            'hasDuplicateIds'           => $groupEqUid->count() < $allEquipUid->count(),
            'duplicateEquipmentUidList' => $grpList
        ];


    }

    public function getAstrayEquipmentUids(): int
    {
        $astrayUidCounter = 0;
        foreach (Equipment::select([
            'id',
            'eq_uid'
        ])->get() as $equipment) {
            $equipmentUid = EquipmentUid::where('equipment_id', $equipment->id)->first();
            if ($equipmentUid) {
                if ($equipmentUid->equipment_uid !== $equipment->eq_uid) {
                    $astrayUidCounter++;
                }
            }
        }
        return $astrayUidCounter;
    }

    public function getBrokenControlEquipmentItems(): array
    {
        /**
         * get all broken entries for equipment control
         */
        $counter = 0;

        $totalControlEquipment = ControlEquipment::withTrashed()->count();
        $brokenItems = [];

        foreach (Anforderung::onlyTrashed()->get() as $anforderung) {
            $items = ControlEquipment::withTrashed()->where('anforderung_id', $anforderung->id);
            $count = $items->count();
            if ($count > 0) {
                $brokenItems[] = $items->first();
                $counter += $count;
            }
        }

        foreach (ControlEquipment::withTrashed()->where('anforderung_id', null)->get() as $control) {
            $brokenItems[] = $control;
            $counter++;

        }

        $brokenEquipmentControl = $counter > 0;

        return [
            'totalControlEquipment'      => $totalControlEquipment,
            'brokenControlEquipment'     => $brokenEquipmentControl,
            'brokenControlEquipmenCount' => $counter,
            'brokenItems'                => $brokenItems,
        ];
    }

    public function getBrokenProductRequirements()
    {

        $items = [];

        foreach (ProduktAnforderung::withTrashed()->with([
            'Produkt',
            'Anforderung'
        ])->get() as $item) {

            if (Produkt::withTrashed()->where('id', $item->produkt_id)->count() == 0) {
                $items[] = $item;
            }
            if (Anforderung::where('id', $item->anforderung_id)->count() == 0) {
                $items[] = $item;
            }
        }
        
        return $items;

    }

    public function getBrokenProductItems()
    {
        return Produkt::withTrashed()->where('prod_uuid', null)->count();
    }

    public function getOrphanRequirementItems(): array
    {
        $orphanRequirementItems = [];
        foreach (AnforderungControlItem::select('id', 'anforderung_id', 'created_at', 'updated_at', 'aci_label', 'aci_name')->get() as $aci) {
            if ($aci->anforderung_id === null) {
                $orphanRequirementItems[] = $aci;
            }
        }
        return $orphanRequirementItems;
    }

    public function getBrokenDBLinks()
    {
        return Cache::remember('system-status-database', now()->addHours(12), function () {
            $brokenLinksCount = 0;
            $brokenEquipmentControl = $this->getBrokenControlEquipmentItems();
            $brokenProducts = $this->getBrokenProductItems();
            $brokenProductRequiremnets = $this->getBrokenProductRequirements();
            $brokenLinksCount += $brokenEquipmentControl['brokenControlEquipmenCount'];
            $orphanACI = $this->getOrphanRequirementItems();
            $brokenControlItems = $brokenEquipmentControl['brokenItems'];
            $orphanEquipmentUids = $this->countOrphanEquipmentUids();


            return [
                'missingEquipmentUuids'         => $this->getBrockenEquipmentUuids(),
                'brokenProductRequiremnets'     => count($brokenProductRequiremnets),
                'brokenProductRequiremnetItems' => $brokenProductRequiremnets,
                'brokenProducts'                => $brokenProducts,
                'totalBrokenLinks'              => $brokenLinksCount,
                'brokenControlItems'            => $brokenControlItems,
                'equipmentControl'              => $brokenEquipmentControl,
                'orphanRequirementItems'        => count($orphanACI),
                'orphanRequirementItemList'     => $orphanACI,
                'orphanEquipmentUids'           => $orphanEquipmentUids,
                'duplicate_uuids'               => $this->getDuplicateUuIds(),
                'astrayEquipmentUids'           => $this->getAstrayEquipmentUids(),
            ];
        });


    }

    public function getObjectStatus(): array
    {

        return Cache::remember('system-status-objects', now()->addHours(12), function () {
            $incomplete_equipment = false;
            $incomplete_requirement = 0;
            foreach (Anforderung::all() as $requirement) {
                $incomplete_requirement += $requirement->AnforderungControlItem()->count() > 0
                    ? 0
                    : 1;
            }

            $service = new EquipmentEventService();

            $equipment = Equipment::select('id')->get();
            $countEquipment = $equipment->count();
            foreach ($equipment as $item) {
                $incomplete_equipment += ControlEquipment::select('id')->where('equipment_id', $item->id)->count() === 0
                    ? 1
                    : 0;
            }

            $countControlEquipment = Equipment::with(['Produkt'])->get()->map(function ($value) {

                return $value->isControlProdukt($value) != null;
            })->sum();

            $countProducts = Produkt::count();


            return [
                'foundExpiredControlEquipment' => $service->findExpiredEquipmentControlItems(),
                'products'                     => $countProducts,
                'equipment'                    => $countEquipment,
                'control_products'             => ControlProdukt::all()->count(),
                'control_equipment'            => $countControlEquipment,
                'storages'                     => Storage::all()->count(),
                'equipment_qualified_user'     => EquipmentQualifiedUser::all()->count(),
                'product_qualified_user'       => ProductQualifiedUser::all()->count(),
                'regulations'                  => Verordnung::all()->count(),
                'requirements'                 => Anforderung::all()->count(),
                'incomplete_requirement'       => $incomplete_requirement,
                'incomplete_equipment'         => $incomplete_equipment,
                'requirements_items'           => AnforderungControlItem::all()->count(),
            ];
        });

    }


}
