<?php

    namespace App\Http\Services\Equipment;

    use App\ControlEquipment;
    use App\ControlProdukt;
    use App\Equipment;
    use App\EquipmentEvent;
    use App\EquipmentQualifiedUser;
    use App\ProductQualifiedUser;
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

        public function getExpiredEquipmentControlItems(): array
        {
            return $this->makeEquipmentControlCollection()->map(function ($item)
            {
                return EquipmentEventService::checkControlDueDateIsExpired($item);
            })->toArray();

        }

        public function findExpiredEquipmentControlItems():bool
        {
            return gettype(array_search(true, $this->getExpiredEquipmentControlItems()))==='integer';
        }


        public function findAvaliableEquipmentControlItems():bool
        {

            return gettype(array_search(false, $this->getExpiredEquipmentControlItems()))==='integer';
        }

        public static function checkControlDueDateIsExpired(Equipment $equipment): bool
        {
            /**
             * if equipment has an upcomming control item
             * check if due date is expired = true
             */
            $eq = $equipment->ControlEquipment()->first();

            if ($eq){
                return $eq->qe_control_date_due <= now();
            }

            /**
             *  if no upcomming control item was found
             *  return true for an expired or not yet
             *  controlled equipment
             */
            return true;
        }


        public function getQuaifiedUserList(ControlEquipment $controlItem):array
        {
            $enabledUser=[];
            foreach (ProductQualifiedUser::where('produkt_id', $controlItem->Equipment->produkt->id)->get() as $qualifiedUser) {
                $enabledUser[] = [
                    'id'   => $qualifiedUser->user_id,
                    'name' => $qualifiedUser->user->name,
                ];
            }

            foreach (EquipmentQualifiedUser::where('equipment_id', $controlItem->Equipment->id)->get() as $qualifiedUser) {
                $enabledUser[] = [
                    'id'   => $qualifiedUser->user_id,
                    'name' => $qualifiedUser->user->name,
                ];
            }
            return $enabledUser;
        }


    }
