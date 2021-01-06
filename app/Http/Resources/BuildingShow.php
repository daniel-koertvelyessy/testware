<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'created' => (string)$this->created_at,
            'updated' => (string)$this->updated_at,
            'identifier' => $this->b_name_kurz,
            'uid' => $this->standort_id,
            'name' => $this->b_name_lang,
            'place' => $this->b_name_ort,
            'description' => $this->b_name_text,
            'goods_income_has' => ($this->b_we_has===0)?false:true,
            'goods_income_name' => $this->b_we_name,
            'type' => new BuildingType($this->BuildingType),
            'location' => new LocationShort($this->location),
        ];
    }
}
