<?php

    namespace App\Http\Services\Control;

    use App\ControlEquipment;
    use App\ControlEvent;
    use App\Equipment;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;

    class ControlEventService
    {

        protected function query(string $term)
        {
            return ControlEvent::whereRaw('lower(control_event_text) like ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(control_event_supervisor_name) like ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(control_event_controller_name) like ?', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new ControlEventService)->query($term) as $ret) {
                $data[] = [
                    'link' => route('control.show', $ret),
                    'label' => '[' . __('Prüfung') . '] ' . $ret->control_event_date . ' Text: ' . str_limit($ret->control_event_text, 20)
                ];
            }
            return $data;
        }

        public static function search(string $term)
        {
            return (new ControlEventService)->query($term);
        }

        public function syncEquipment(string $uuid, bool $deleteExistingControlItems=false): array
        {
            $dataset = [];
            $equipment = Equipment::where('eq_uid', $uuid)->first();

            if ($deleteExistingControlItems) $dataset['deleted'] = count( $this->deleteControlItems($equipment));

            foreach ($equipment->produkt->ProduktAnforderung as $requirement) {
                $anforderung = $requirement->Anforderung;

                if (ControlEquipment::where([
                        'anforderung_id' => $anforderung->id,
                        'equipment_id'   => $equipment->id
                    ])->count() == 0) {
                    if(!$anforderung->is_initial_test) {
                        $control = new ControlEquipment();
                        $control->qe_control_date_last = now();
                        $control->qe_control_date_due = $equipment->created_at->add($anforderung->ControlInterval->ci_delta, $anforderung->an_control_interval);
                        $control->qe_control_date_warn = $anforderung->an_date_warn;
                        $control->control_interval_id = $anforderung->control_interval_id;
                        $control->equipment_id = $equipment->id;
                        $control->anforderung_id = $anforderung->id;
                        $dataset['new'][] = $control->save()
                            ? $control->id
                            : '';
                    }
                }
            }

            return $dataset;


        }

        public function deleteControlItems(Equipment $equipment): Collection
        {

          return ControlEquipment::where('equipment_id',$equipment->id)->get()->map(function ($item, $key){
                return $item->forceDelete();
            });


        }

        public function makeSyncMessageText(array $results)
        {

            $numNewControl = 0;
            $numDeletions = 0;
            $msg='';

            foreach($results as $result){
                $numDeletions += $result['deleted']??0;
                $numNewControl += isset($result['new']) ? count($result['new']) : 0;
            }

            if($numNewControl>0 || $numDeletions>0) {
                $msg .= __('Es wurden :num Geräte synchronisiert. ', ['num' => count($results)]);

                $msg .= $numNewControl > 0
                    ? __('<br>Insgesamt :num neue Prüfungen angelegt. ', ['num' => $numNewControl])
                    : __('Es wurden keine neuen Prüfungen angelegt. ');
                $msg .= $numDeletions > 0
                    ? __('<br>Insgesamt :num existierende Prüfungen gelöscht. ', ['num' => $numDeletions])
                    : __('Es wurden keine Prüfungen gelöscht. ');
            } else {
                $msg.= __('Ausgewählten Geräte sind bereits synchron. Es wurden keine Aktionen ausgeführt!');
            }

            return $msg;
        }


    }