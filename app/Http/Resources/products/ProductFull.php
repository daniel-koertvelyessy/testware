<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFull extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request) {
        $productParams=[];

        foreach ($this->ProduktParam as $params)
            $productParams[] = new ProductParam($params);

        return [
            'id'            => $this->id,
            'created'       => (string)$this->created_at,
            'updated'       => (string)$this->updated_at,
            'label'         => $this->prod_name_kurz,
            'name'          => $this->prod_name_lang,
            'description'   => $this->prod_name_text,
            'part_number'   => $this->prod_nummer,
            'status_active' => ($this->prod_active === 0) ? false : true,
            'parameter'      => $productParams,
            'category'      => new ProductCategory($this->ProduktKategorie),
            'product_state' => new ProductStateShort($this->ProduktState),
            'object'  => new ProductStats($this)
        ];
    }
}
/**
ProduktKategorie
ProduktState
ProduktParam
ProduktAnforderung
firma
Equipment
ControlProdukt
 *
 */
