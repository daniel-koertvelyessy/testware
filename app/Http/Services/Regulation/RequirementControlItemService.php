<?php

    namespace App\Http\Services\Regulation;

    use App\AnforderungControlItem;

    class RequirementControlItemService
    {

        protected function getRequirementControlItemItems($term){
            return AnforderungControlItem::whereRaw('lower(aci_label) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(aci_name) like ? ', '%' . strtolower($term) . '%')
                ->orWhereRaw('lower(aci_task) like ? ', '%' . strtolower($term) . '%')
                ->get();
        }

        public static function getSearchResults($term):array
        {
            $data=[];
            foreach ((new RequirementControlItemService)->getRequirementControlItemItems($term) as $ret) {
                $data[] = [
                    'link'  => route('anforderungcontrolitem.show', $ret),
                    'label' => '[' . __('Vorgang') . '] ' . str_limit($ret->aci_name, 30)
                ];
            }

            return $data;
        }
    }