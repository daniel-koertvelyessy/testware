<?php

namespace App\Http\Resources\contacts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Contact extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'created'   => (string)$this->created_at,
            'updated'   => (string)$this->updated_at,
            'label'     => $this->label,
            'name'      => $this->name,
            'name_2'    => $this->name_2,
            'vorname'   => $this->vorname,
            'position'  => $this->position,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'mobil'     => $this->mobil,
            'fax'       => $this->fax,
            'com_1'     => $this->com_1,
            'com_2'     => $this->com_2,
            'firma_id'  => $this->firma_id,
            'anrede_id' => $this->anrede_id ?? 1,
        ];
    }
}
