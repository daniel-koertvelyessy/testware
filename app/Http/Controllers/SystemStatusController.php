<?php

namespace App\Http\Controllers;

use App\Anforderung;
use App\AnforderungControlItem;
use App\ControlEquipment;
use App\ControlProdukt;
use App\Equipment;
use App\EquipmentQualifiedUser;
use App\EquipmentUid;
use App\Http\Services\Equipment\EquipmentEventService;
use App\Http\Services\Equipment\EquipmentService;
use App\ProductQualifiedUser;
use App\Produkt;
use App\ProduktAnforderung;
use App\Storage;
use App\Verordnung;
use Cache;

class SystemStatusController extends Controller
{
    public function countOrphanEquipmentUids()
    {
        return EquipmentUid::with('Equipment')
            ->select('equipment_uid', 'equipment_id')
            ->doesntHave('Equipment') // Use doesntHave to directly filter orphan records
            ->count();
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

        $allEquipUid = Equipment::select(['id', 'eq_uid', 'eq_name', 'eq_inventar_nr', 'created_at'])->get();

        $groupEqUid = $allEquipUid->groupBy('eq_uid');

        $grpList = $allEquipUid->filter(function ($equipment) {
            if (Equipment::where('eq_uid', $equipment->eq_uid)->count() > 1) {
                return $equipment;
            }
        });

        return [
            'hasDuplicateIds' => $groupEqUid->count() < $allEquipUid->count(),
            'duplicateEquipmentUidList' => $grpList,
        ];

    }

    public function getAstrayEquipmentUids(): int
    {
        $astrayUidCounter = 0;
        foreach (Equipment::select([
            'id',
            'eq_uid',
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
        $brokenItems = [];
        $totalControlEquipment = ControlEquipment::withTrashed()->count();

        // Fetch only necessary data in one query
        $brokenItems = ControlEquipment::withTrashed()
            ->whereNull('anforderung_id')
            ->orWhereHas('Anforderung', function ($query) {
                $query->onlyTrashed();
            })
            ->get();

        $brokenEquipmentControl = $brokenItems->count() > 0;

        return [
            'totalControlEquipment' => $totalControlEquipment,
            'brokenControlEquipment' => $brokenEquipmentControl,
            'brokenControlEquipmenCount' => $brokenItems->count(),
            'brokenItems' => $brokenItems,
        ];
    }

    public function getBrokenProductRequirements()
    {
        $items = ProduktAnforderung::withTrashed()->with(['Produkt', 'Anforderung'])->get();

        // Filter out broken items
        return $items->filter(function ($item) {
            return ! Produkt::withTrashed()->where('id', $item->produkt_id)->exists() ||
                ! Anforderung::where('id', $item->anforderung_id)->exists();
        });
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

            $countIssues = $brokenLinksCount + count($orphanACI) + count($brokenControlItems) + $orphanEquipmentUids + $this->getAstrayEquipmentUids();

            return [
                'countIssues' => $countIssues,
                'missingEquipmentUuids' => $this->getBrockenEquipmentUuids(),
                'brokenProductRequiremnets' => count($brokenProductRequiremnets),
                'brokenProductRequiremnetItems' => ($brokenProductRequiremnets),
                'brokenProducts' => $brokenProducts,
                'totalBrokenLinks' => $brokenLinksCount,
                'brokenControlItems' => $brokenControlItems,
                'equipmentControl' => $brokenEquipmentControl,
                'orphanRequirementItems' => count($orphanACI),
                'orphanRequirementItemList' => $orphanACI,
                'orphanEquipmentUids' => $orphanEquipmentUids,
                'duplicate_uuids' => $this->getDuplicateUuIds(),
                'astrayEquipmentUids' => $this->getAstrayEquipmentUids(),
            ];
        });

    }

    public function getObjectStatus(): array
    {

        $service = new EquipmentEventService;

        $countEquipment = EquipmentService::count();

        $countProducts = Produkt::count();

        $requirementsCount = Anforderung::count();
        $requirementACICount = Anforderung::has('AnforderungControlItem')->count();

        return [
            'foundExpiredControlEquipment' => $service->findExpiredEquipmentControlItems(),
            'products' => $countProducts,
            'equipment' => $countEquipment,
            'control_products' => ControlProdukt::all()->count(),
            'control_equipment' => Equipment::has('ControlProdukt')->count(),
            'storages' => Storage::all()->count(),
            'equipment_qualified_user' => EquipmentQualifiedUser::all()->count(),
            'product_qualified_user' => ProductQualifiedUser::all()->count(),
            'regulations' => Verordnung::all()->count(),
            'requirements' => $requirementsCount,
            'incomplete_requirement' => $requirementsCount - $requirementACICount,
            'incomplete_equipment' => Equipment::doesntHave('ControlEquipment')->count(),
            'requirements_items' => AnforderungControlItem::count(),
        ];
        //        });

    }
}
