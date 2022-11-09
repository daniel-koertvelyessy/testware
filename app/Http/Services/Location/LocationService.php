<?php

    namespace App\Http\Services\Location;

    use App\Location;

    class LocationService
    {

        public function query(string $term)
        {
            return Location::whereRaw('lower(l_label) like ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(l_name) like ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(l_beschreibung) like ?', '%' . strtolower($term) . '%')->get();
        }

        public static function searchResults(sring $term): array
        {
            $data = [];
            foreach ((new LocationService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('location.show', $ret),
                    'label' => '[' . __('Standort') . '] ' . $ret->l_label
                ];
            }
            return $data;
        }

        public static function search(string $term)
        {
            return (new LocationService())->query($term);
        }

    }