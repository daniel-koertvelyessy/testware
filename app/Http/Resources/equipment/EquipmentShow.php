<?php

namespace App\Http\Resources\equipment;

use App\ControlEquipment;
use App\EquipmentInstruction;
use App\EquipmentQualifiedUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $testingList = [];

        foreach (ControlEquipment::withTrashed()->where('equipment_id', $this->id)->get() as $listItem) {
            if ($listItem->deleted_at) {
                $status = [
                    'completed' => true,
                    'completed_at' => (string) $listItem->deleted_at,
                ];
            } else {
                $status = [
                    'completed' => false,
                    'completed_at' => false,
                ];
            }

            $testingList[$listItem->id] =
                [
                    'requirement' => $listItem->Anforderung->an_label,
                    'last_at' => (string) $listItem->qe_control_date_due,
                    'due_at' => (string) $listItem->qe_control_date_last,
                    'status' => $status,
                ];
        }

        $qualifiedUserList = [];
        foreach (EquipmentQualifiedUser::where('equipment_id', $this->id)->get() as $qualifiedUser) {
            $qualifiedUserList[$qualifiedUser->id] = [
                'qualified_by' => $qualifiedUser->firma->fa_name,
                'qualified_at' => (string) $qualifiedUser->equipment_qualified_date,
                'qualiffied_user' => $qualifiedUser->user->name,
            ];

        }

        $instructedUserList = [];
        foreach (EquipmentInstruction::where('equipment_id', $this->id)->get() as $instructedUser) {
            $instructed_by = ($instructedUser->equipment_instruction_instructor_profile_id === 0)
                ? $instructedUser->firma->fa_name
                : $instructedUser->instructor->fullName();

            $instructedUserList[$instructedUser->id] = [
                'instructed_at' => $instructedUser->equipment_instruction_date,
                'instructed_by' => $instructed_by,
                'instructed_user' => $instructedUser->trainee->fullName(),
            ];
        }

        return [
            'created' => (string) $this->created_at,
            'updated' => (string) $this->updated_at,
            'installed' => (string) $this->installed_at,
            'purchased' => (string) $this->purchased_at,
            'status' => $this->EquipmentState->estat_label,
            'name' => $this->eq_name,
            'uid' => $this->eq_uid,
            'inventory' => $this->eq_inventar_nr,
            'serial' => $this->eq_serien_nr,
            'price' => $this->eq_price,
            'storage' => $this->storage->storage_label,
            'testing' => $testingList,
            'qualified' => $qualifiedUserList,
            'instructed' => $instructedUserList,
        ];
    }
}
