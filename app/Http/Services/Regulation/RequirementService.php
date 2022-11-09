<?php

    namespace App\Http\Services\Regulation;

    use App\Anforderung;

    class RequirementService
    {

        protected function query(string $term)
        {
            return Anforderung::whereRaw('LOWER(an_label) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(an_name) LIKE ?', '%' . strtolower($term) . '%')
                ->orWhereRaw('LOWER(an_description) LIKE ?', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults(string $term): array
        {
            $data = [];
            foreach ((new RequirementService)->query($term) as $ret) {
                $data[] = [
                    'link'  => route('anforderung.show', $ret),
                    'label' => '[' . __('Anforderung') . '] ' . str_limit($ret->an_name, 30)
                ];
            }
            return $data;
        }

        public static function search(string $term)
        {
            return (new RequirementService())->query($term);
        }

    }