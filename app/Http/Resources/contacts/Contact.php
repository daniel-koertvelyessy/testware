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
            'id'         => $this->id,
            'created'    => (string)$this->created_at,
            'updated'    => (string)$this->updated_at,
            'label'      => $this->con_label,
            'last_name'  => $this->con_name,
            'name_2'     => $this->con_name_2,
            'first_name' => $this->con_vorname,
            'position'   => $this->con_position,
            'email'      => $this->con_email,
            'phone'      => $this->con_phone,
            'mobil'      => $this->con_mobil,
            'fax'        => $this->con_fax,
            'com_1'      => $this->con_com_1,
            'com_2'      => $this->con_com_2,
            'firma_id'   => $this->firma_id,
            'anrede_id'  => $this->anrede_id ?? 1,
        ];
    }
}
