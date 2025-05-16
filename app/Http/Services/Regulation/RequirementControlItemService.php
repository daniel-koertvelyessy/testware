<?php

namespace App\Http\Services\Regulation;

use App\Anforderung;
use App\AnforderungControlItem;

class RequirementControlItemService
{
    protected function getRequirementControlItemItems($term)
    {
        return AnforderungControlItem::where('aci_label', 'ILIKE', '%'.strtolower($term).'%')
            ->orWhere('aci_name', 'ILIKE', '%'.strtolower($term).'%')
            ->orWhere('aci_task', 'ILIKE', '%'.strtolower($term).'%')
            ->get();
    }

    public static function getSearchResults($term): array
    {
        $data = [];
        foreach ((new RequirementControlItemService)->getRequirementControlItemItems($term) as $ret) {
            $data[] = [
                'link' => route('anforderungcontrolitem.show', $ret),
                'label' => '['.__('Vorgang').'] '.str_limit($ret->aci_name, 30),
            ];
        }

        return $data;
    }

    public function getLatestSort(Anforderung $anforderung): int
    {
        return 0;
    }

    public function resortItems(array $oldsort, int $newitem, Anforderung $anforderung)
    {

        $position = array_search($newitem, $oldsort);
        $pre_array = array_slice($oldsort, 0, $position + 1);
        $post_array = array_slice($oldsort, $position + 1);

        $new = array_merge($pre_array, [$newitem + 1], $post_array);

        foreach ($anforderung->AnforderungControlItem as $key => $aci) {

            $aci->aci_sort = $new[$key];
            $aci->save();

        }

        $this->renewListPos($anforderung);

    }

    public function renewListPos(Anforderung $anforderung)
    {

        $pos = 5;

        foreach ($anforderung->AnforderungControlItem()->orderBy('aci_sort')->get() as $aci) {

            $aci->aci_sort = $pos;
            $aci->save();

            $pos = $pos + 5;

        }

    }
}
