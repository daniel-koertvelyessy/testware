<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentParam extends Model
{
    public function addParam(
        string $label,
        string $value,
        string $name,
        int $equipment_id
    ): bool {
        $this->ep_label = $label;
        $this->ep_name = $name;
        $this->ep_value = $value;
        $this->equipment_id = $equipment_id;

        return $this->save();
    }

    public function addEquipment(
        int $param_id,
        string $param_value,
        int $equipment_id
    ): bool {
        $produktParam = ProduktParam::find($param_id);
        $this->ep_label = $produktParam->pp_label;
        $this->ep_name = $produktParam->pp_name;
        $this->ep_value = $param_value;
        $this->equipment_id = $equipment_id;

        return $this->save();
    }

    public function storeProductParameter(
        array $parameterData,
        int $equipment_id
    ): bool {
        if (EquipmentParam::where('ep_label',
            $parameterData['ep_label'] ?? $parameterData['pp_label'])
            ->where('equipment_id',
                $equipment_id)
            ->count() > 0) {

            $this->updateEquipmentParameter($parameterData,
                $equipment_id);

            return false;
        }
        $this->ep_label = $parameterData['ep_label'] ?? $parameterData['pp_label'];
        $this->ep_name = $parameterData['ep_name'] ?? $parameterData['pp_name'];
        $this->ep_value = $parameterData['ep_value'] ?? $parameterData['pp_value'];
        $this->equipment_id = $equipment_id;
        if ($this->save()) {
            return $this->id;
        } else {
            return false;
        }
    }

    public function updateEquipmentParameter(array $parameterData, int $equipment_id): bool
    {
        $param = EquipmentParam::where('equipment_id',
            $equipment_id)
            ->where('ep_label',
                $parameterData['ep_label'] ?? $parameterData['pp_label'])
            ->first();

        $param->ep_name = $parameterData['ep_name'] ?? $parameterData['pp_name'];
        $param->ep_value = $parameterData['ep_value'] ?? $parameterData['pp_value'];

        return $param->update();
    }

    public function deleteProductParameter(
        array $parameterData,
        int $equipment_id
    ): bool {
        $productParameter = ProduktParam::find($parameterData['id']);

        return EquipmentParam::where([
            [
                'ep_label',
                $productParameter->pp_label,
            ],
            [
                'equipment_id',
                $equipment_id,
            ],
        ])->delete();
    }
}
