<?php

    namespace App\Http\Services\Location;

    use App\Stellplatz;

    class CompartmentService
    {

        protected function getCompartmentItems(string $term)
        {
            return Stellplatz::whereRaw('lower(sp_label) like ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(sp_name) like ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(sp_description) like ?', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new CompartmentService)->getCompartmentItems($term) as $ret) {
                $data[] = [
                    'link'  => route('room.show', $ret),
                    'label' => '[' . __('Stellplatz') . '] ' . $ret->sp_label
                ];
            }
            return $data;
        }

        public static function search(string $term)
        {
            return (new CompartmentService)->getCompartmentItems($term);
        }

    }