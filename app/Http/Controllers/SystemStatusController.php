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
    use function PHPUnit\Framework\isType;

    class SystemStatusController extends Controller
    {

        public function getBrockenEquipmentUuids()
        {

            $counter = Equipment::withTrashed()->get()->map(function (Equipment $equipment)
            {
                return EquipmentUid::where('equipment_uid', $equipment->eq_uid)->count() == 0
                    ? 1
                    : 0;
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

            foreach (ProduktAnforderung::all() as $item) {

                if (Produkt::withTrashed()->where('id', $item->produkt_id)->count() == 0) $items[] = $item;
                if (Anforderung::where('id', $item->anforderung_id)->count() == 0) $items[] = $item;
            }

            return $items;

        }

        public function getBrokenProductItems()
        {
            return Produkt::withTrashed()->where('prod_uuid', null)->count();
        }

        public function getBrokenDBLinks()
        {
            $brokenLinksCount = 0;
            $brokenEquipmentControl = $this->getBrokenControlEquipmentItems();
            $brokenProducts = $this->getBrokenProductItems();
            $brokenProductRequiremnets = $this->getBrokenProductRequirements();
            $brokenLinksCount += $brokenEquipmentControl['brokenControlEquipmenCount'];

            $brokenControlItems = $brokenEquipmentControl['brokenItems'];

            //       return Cache::remember('system-status-counter', now()->addSeconds(10), function () use ($brokenEquipmentControl, $counter){
            return [
                'missingEquipmentUuids'         => $this->getBrockenEquipmentUuids(),
                'brokenProductRequiremnets'     => count($brokenProductRequiremnets),
                'brokenProductRequiremnetItems' => $brokenProductRequiremnets,
                'brokenProducts'                => $brokenProducts,
                'totalBrokenLinks'              => $brokenLinksCount,
                'brokenControlItems'            => $brokenControlItems,
                'equipmentControl'              => $brokenEquipmentControl
            ];
            //       });


        }

        public function getObjectStatus(): array
        {

            return Cache::remember('system-status-counter', now()->addSeconds(10), function ()
            {
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

                $countControlEquipment = Equipment::with('produkt')->get()->map(function ($value)
                {
                    return $value->produkt->ControlProdukt != null;
                })->sum();

                $countProducts = Produkt::all()->count();


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