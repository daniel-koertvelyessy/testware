<?php

    namespace App\Http\Services\Equipment;

    use App\EquipmentEvent;
    use App\EquipmentEventItem;

    class EquipmentEventItemService
    {

        protected function query(string $term)
        {
            return EquipmentEventItem::where('equipment_event_item_text','ILIKE', '%' . strtolower($term) . '%')
                ->get();
        }


        public static function getSearchResults($term): array
        {
            $data = [];
            foreach ((new EquipmentEventItemService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('equipmenteventitem.show', $ret),
                    'label' => '[' . __('Meldung') . '] ' . $ret->updated_at . ' Text: ' . str_limit($ret->equipment_event_item_text, 20)
                ];
            }
            return $data;
        }


    }