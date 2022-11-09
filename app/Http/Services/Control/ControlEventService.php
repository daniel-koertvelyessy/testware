<?php

    namespace App\Http\Services\Control;

    use App\ControlEvent;

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
                    'link'  => route('control.show', $ret),
                    'label' => '[' . __('Prüfung') . '] ' . $ret->control_event_date . ' Text: ' . str_limit($ret->control_event_text, 20)
                ];
            }
            return $data;
        }

        public static function search(string $term)
        {
            return (new ControlEventService)->query($term);
        }

    }