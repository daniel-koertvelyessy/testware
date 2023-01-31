<?php

    namespace App\Http\Services\Location;

    use App\Location;

    class LocationService
    {

        public function query(string $term)
        {
            return Location::where('l_label','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('l_name','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('l_beschreibung','ILIKE', '%' . strtolower($term) . '%')->get();
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