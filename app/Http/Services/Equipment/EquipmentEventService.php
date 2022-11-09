<?php

    namespace App\Http\Services\Equipment;

    use App\EquipmentEvent;
    use App\EquipmentEventItem;

    class EquipmentEventService
    {


        protected function query(string $term)
        {
            return EquipmentEvent::whereRaw('lower(equipment_event_text) like ? ', '%' . strtolower($term) . '%')
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


    }