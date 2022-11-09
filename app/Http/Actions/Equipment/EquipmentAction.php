<?php

    namespace App\Http\Actions\Equipment;

    use App\ControlEquipment;
    use App\Equipment;
    use App\EquipmentDoc;
    use App\EquipmentEvent;
    use App\EquipmentInstruction;
    use App\EquipmentParam;
    use App\EquipmentQualifiedUser;
    use App\ProduktDoc;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;

    class EquipmentAction
    {
        public static function deleteLoseProductDocumentEntries(Equipment $equipment): void
        {
            foreach (ProduktDoc::where('produkt_id', $equipment->Produkt->id)->where('document_type_id', 1)->get() as $productDocFile) {
                if (Storage::disk('local')->missing($productDocFile->proddoc_name_pfad)) {
                    Log::warning('Dateireferenz (' . $productDocFile->proddoc_name_pfad . ') aus DB EquipmentDoc existiert nicht auf dem Laufwerk. Datensatz wird gelöscht!');
//                dump('delete '. $productDocFile->eqdoc_name_pfad);
                    $productDocFile->delete();
                }

            }
        }

        public static function deleteLoseEquipmentDocumentEntries(Equipment $equipment): void
        {
            foreach (EquipmentDoc::where('equipment_id', $equipment->id)->where('document_type_id', 2)->get() as $equipmentDocFile) {
                if (Storage::disk('local')->missing($equipmentDocFile->eqdoc_name_pfad)) {
                    Log::warning('Dateireferenz für Funktionsprüfung (' . $equipmentDocFile->eqdoc_name_pfad . ') aus DB EquipmentDoc existiert nicht auf dem Laufwerk. Datensatz wird gelöscht!');
//                dump('delete '. $equipmentDocFile->eqdoc_name_pfad);
                    $equipmentDocFile->delete();
                }

            }
        }


        public static function deleteRelatedObjetcs(Equipment $equipment): array
        {
            $eDoc = 0;
            $eEv = 0;
            $eQu = 0;
            $eIn = 0;
            $ePa = 0;
            $eCon = 0;

            foreach (EquipmentDoc::where('equipment_id', $equipment->id)->get() as $prodDoku) {
                EquipmentDoc::find($prodDoku->id);
                Storage::delete($prodDoku->proddoc_name_pfad);
                if ($prodDoku->delete()) $eCon++;

            }

            foreach (ControlEquipment::where('equipment_id', $equipment->id)->get() as $eevent) {
                if ($eevent->delete()) $eEv++;

            }

            foreach (EquipmentEvent::where('equipment_id', $equipment->id)->get() as $eevent) {
                if ($eevent->delete()) $eEv++;

            }

            foreach (EquipmentQualifiedUser::where('equipment_id', $equipment->id)->get() as $eevent) {
                if ($eevent->delete()) $eQu++;
            }

            foreach (EquipmentInstruction::where('equipment_id', $equipment->id)->get() as $eevent) {
                if ($eevent->delete()) $eIn++;
            }

            foreach (EquipmentParam::where('equipment_id', $equipment->id)->get() as $eevent) {
                if ($eevent->delete()) $ePa++;
            }

            return [
                'eCon' => $eCon,
                'eDoc' => $eDoc,
                'eEv'  => $eEv,
                'eQu'  => $eQu,
                'eIn'  => $eIn,
                'ePa'  => $ePa,
            ];

        }

    }