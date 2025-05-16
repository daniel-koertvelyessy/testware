<?php

namespace App\Http\Services\Regulation;

use App\Anforderung;
use App\ProduktAnforderung;

class RequirementService
{
    protected function query(string $term)
    {
        return Anforderung::where('an_label', 'ILIKE', '%'.strtolower($term).'%')
            ->orWhere('an_name', 'ILIKE', '%'.strtolower($term).'%')
            ->orWhere('an_description', 'ILIKE', '%'.strtolower($term).'%')
            ->get();
    }

    public static function getSearchResults(string $term): array
    {
        $data = [];
        foreach ((new RequirementService)->query($term) as $ret) {
            $data[] = [
                'link' => route('anforderung.show', $ret),
                'label' => '['.__('Anforderung').'] '.str_limit($ret->an_name, 30),
            ];
        }

        return $data;
    }

    public static function search(string $term)
    {
        return (new RequirementService)->query($term);
    }

    public function deleteRelatedItems(Anforderung $anforderung)
    {
        $msg = $this->deleteProductRequirement($anforderung);

        //  ControlEquipment::withTrashed()->where('anforderung_id',$anforderung->id)->delete();
    }

    public function deleteProductRequirement(Anforderung $anforderung)
    {

        $items = ProduktAnforderung::withTrashed()->where('anforderung_id', $anforderung->id);
        $counter = $items->count();

        return $items->delete() ? __('Produktanforderung gelöscht') : __('Fehler beim Löschen der Produktanforderung');
    }
}
