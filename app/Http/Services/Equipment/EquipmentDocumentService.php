<?php

    namespace App\Http\Services\Equipment;

    use App\DocumentType;
    use App\Equipment;
    use App\EquipmentDoc;
    use App\EquipmentQualifiedUser;
    use App\ProductQualifiedUser;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;

    class EquipmentDocumentService
    {
        public $prefix = 'equipment_files/';

        public static function getEquipmentPathName(Equipment $equipment){
            return (new EquipmentDocumentService)->getEquipmentPath($equipment);
        }

        public function getEquipmentPath(Equipment $equipment): string
        {
            return $this->prefix . $equipment->id . '/';
        }

        public function generateFilePath(Equipment $equipment, string $name)
        {
            return $this->prefix . $equipment->id . '/' . $name;
        }

        public function getFunctionTestDocumentList(Equipment $equipment)
        {
          return  EquipmentDoc::where('equipment_id', $equipment->id)->where('document_type_id', 2)->get();
        }

        public function getDocumentList(Equipment $equipment)
        {
          return  EquipmentDoc::where('equipment_id', $equipment->id)->get();
        }

        public function getEquipmentDocList(Equipment $equipment): array
        {
            $fileList = [];
            foreach (Storage::files($this->getEquipmentPath($equipment)) as $path) {
                list(, $file) = explode($this->getEquipmentPath($equipment), $path);
                $fileList[] = $file;
            }
            return $fileList;
        }

        public function checkEquipmentDocInDB(Equipment $equipment, string $filename): bool
        {
            return EquipmentDoc::where('eqdoc_name_pfad', $this->generateFilePath($equipment, $filename))->exists();
        }

        public function checkStorageSyncDB(Equipment $equipment): array
        {
            $newFileList = [];
            foreach ($this->getEquipmentDocList($equipment) as $item) {
                if (!$this->checkEquipmentDocInDB($equipment, $item)) $newFileList[] = $item;
            }
            return $newFileList;
        }

        public function makeDocumentTypeSelector(int $id = 0, int $selectedId = NULL)
        {
            $html = '
            <select class="custom-select" id="setDocTypeID' . $id . '" name="setDocTypeID[]">
                <option '.($selectedId === NULL ? "selected" : "" ).' value="0" >' . __('Datei löschen') . '</option>
                <optgroup label="Neu speichern als:">';

            foreach (DocumentType::select('id', 'doctyp_label')->get() as $docType) {

                $html .= '<option '.($selectedId === $docType->id ? "selected" : "" ).' value="' . $docType->id . '">' . $docType->doctyp_label . '</option>';

            }


            $html .= '</optgroup></select>';

            return $html;

        }


    }