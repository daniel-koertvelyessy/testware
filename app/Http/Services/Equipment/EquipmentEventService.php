<?php

    namespace App\Http\Services\Equipment;

    use App\ControlProdukt;
    use App\Equipment;
    use App\EquipmentEvent;
    use Illuminate\Support\Collection;


    class EquipmentEventService
    {


        protected function query(string $term)
        {
            return EquipmentEvent::where('equipment_event_text', 'ILIKE', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new EquipmentEventService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('equipmentevent.show', $ret),
                    'label' => '[' . __('Ereignis') . '] vom ' . $ret->created_at . ' Meldung: ' . str_limit($ret->equipment_event_text, 10)
                ];
            }
            return $data;
        }

        public static function search(string $term)
        {
            return (new EquipmentEventService)->query($term);
        }

        public function makeEquipmentControlCollection(): Collection
        {

            return ControlProdukt::select('id', 'produkt_id')->get()
                ->map(function ($item)
                {
                    return Equipment::where('produkt_id', $item->produkt_id)->get();
                })
                ->flatten();

        }

        public function checkExpiredEquipmentControlItems(): Collection
        {

            return $this->makeEquipmentControlCollection()->map(function ($item)
            {
                return EquipmentEventService::checkControlDueDateExpired($item);
            });

        }



        public static function checkControlDueDateExpired(Equipment $equipment): bool
        {
            $eq = $equipment->ControlEquipment()->first();
            if ($eq){
                return $eq->qe_control_date_due > now();
            }
            return false;
        }


    }