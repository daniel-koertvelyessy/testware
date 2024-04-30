<?php

    namespace App\Http\Services\Control;

    use App\Anforderung;
    use App\ControlInterval;

    class ControlEquipmentService
    {

        public function setIntervalTypeSelector(string $idname, int $item_id = 0, int $selectedId = NULL)
        {
            $html = '
            <select class="custom-select" id="' .$idname . $item_id . '" name="'.$idname.'">
                <option '.($selectedId === NULL ? "selected" : "" ).' value="0" >' . __('bitte auswählen') . '</option>';

            foreach (ControlInterval::select('id', 'ci_label')->get() as $intervalType) {

                $html .= '<option '.($selectedId === $intervalType->id ? "selected" : "" ).' value="' . $intervalType->id . '">' . $intervalType->ci_label . '</option>';

            }

            $html .= '</select>';

            return $html;

        }

        public function setRequirementSelector(string $idname, int $item_id = 0, int $selectedId = NULL)
        {
            $html = '
            <select class="custom-select" id="' .$idname . $item_id . '" name="'.$idname.'">
            ';

            foreach (Anforderung::select(['id', 'an_label'])->get() as $requirement) {

                $html .= '<option '.($selectedId === $requirement->id ? "selected" : "" ).' value="' . $requirement->id . '">' . $requirement->an_label . '</option>';

            }

            $html .= '</select>';

            return $html;

        }

    }