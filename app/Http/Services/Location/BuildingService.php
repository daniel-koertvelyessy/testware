<?php

    namespace App\Http\Services\Location;

    use App\Building;

    class BuildingService
    {

        public function query(string $term)
        {
            return Building::where('b_label','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('b_name_ort', 'ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('b_name', 'ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('b_description', 'ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('b_we_name', 'ILIKE', '%' . strtolower($term) . '%')->get();
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