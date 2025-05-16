<?php

namespace App\Http\Services\Regulation;

use App\Verordnung;

class RegulationService
{
    protected function query(string $term)
    {
        $term = strtolower($term);

        return Verordnung::where('vo_label', 'ILIKE', '%'.$term.'%')
            ->orWhere('vo_name', 'ILIKE', '%'.$term.'%')
            ->orWhere('vo_nummer', 'ILIKE', '%'.$term.'%')
            ->orWhere('vo_stand', 'ILIKE', '%'.$term.'%')
            ->orWhere('vo_description', 'ILIKE', '%'.$term.'%')
            ->get();
    }

    public static function getSearchResults(string $term): array
    {
        $data = [];
        foreach ((new RegulationService)->query($term) as $ret) {
            $data[] = [
                'link' => route('verordnung.show', $ret),
                'label' => '['.__('Verordnung').'] '.str_limit($ret->vo_name, 30),
            ];
        }

        return $data;
    }

    public static function search(string $term)
    {
        return (new RegulationService)->query($term);
    }
}
