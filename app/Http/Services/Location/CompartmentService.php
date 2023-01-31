<?php

    namespace App\Http\Services\Location;

    use App\Stellplatz;

    class CompartmentService
    {

        protected function getCompartmentItems(string $term)
        {
            return Stellplatz::where('sp_label','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('sp_name','ILIKE', '%' . strtolower($term) . '%')
                ->orWhere('sp_description','ILIKE', '%' . strtolower($term) . '%')
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