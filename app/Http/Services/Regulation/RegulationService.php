<?php

    namespace App\Http\Services\Regulation;

    use App\Verordnung;

    class RegulationService
    {

        protected function query(string $term)
        {
            $term = strtolower($term);
            return Verordnung::whereRaw('lower(vo_label) like ?', '%' . $term . '%')
                ->orWhereRaw('lower(vo_name) like ?', '%' . $term . '%')
                ->orWhereRaw('lower(vo_nummer) like ?', '%' . $term . '%')
                ->orWhereRaw('lower(vo_stand) like ?', '%' . $term . '%')
                ->orWhereRaw('lower(vo_description) like ?', '%' . $term . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new RegulationService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('verordnung.show', $ret),
                    'label' => '[' . __('Verordnung') . '] ' . str_limit($ret->vo_name, 30)
                ];
            }

            return $data;
        }

        public static function search(string $term)
        {
            return (new RegulationService)->query($term);
        }

    }