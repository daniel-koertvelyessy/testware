<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EquipmentParam extends Model
{
    /**
     * @param  int  $param_id
     * @param  string  $param_value
     * @param  int  $equipment_id
     *
     * @return bool
     */
    public function addEquipmnt(
        int $param_id,
        string $param_value,
        int $equipment_id
    )
    : bool {
        $produktParam = ProduktParam::find($param_id);
        $this->ep_label = $produktParam->pp_label;
        $this->ep_name = $produktParam->ep_name;
        $this->ep_value = $param_value;
        $this->equipment_id = $equipment_id;
        return $this->save();
    }

    /**
     * @param  Request  $request
     * @param  int  $equipment_id
     *
     * @return bool
     */
    public function storeProductParameter(
        array $parameterData,
        int $equipment_id
    )
    : bool {
        if (EquipmentParam::where('ep_label',
                $parameterData['ep_label'] ?? $parameterData['pp_label'])->count() > 0) {
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

    /**
     * @param  Request  $request
     * @param  int  $equipment_id
     *
     * @return bool
     */
    public function deleteProductParameter(
        array $parameterData,
        int $equipment_id
    )
    : bool {
        $productParameter = ProduktParam::find($parameterData['id']);
        return EquipmentParam::where([
            ['ep_label', $productParameter->pp_label],
            ['equipment_id', $equipment_id]
        ])->delete();
    }

}
