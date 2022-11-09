<?php

    namespace App\Http\Services\Location;

    use App\Building;

    class BuildingService
    {

        public function query(string $term)
        {
            return Building::whereRaw('LOWER(b_label) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(b_name_ort) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(b_name) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(b_description) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(b_we_name) LIKE ?', '%' . strtolower($term) . '%')->get();
        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new BuildingService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('building.show', $ret),
                    'label' => '[' . __('Gebäude') . '] ' . $ret->b_label
                ];
            }
            return $data;
        }

        public static function search(string $term)
        {
            return (new BuildingService)->query($term);
        }


    }