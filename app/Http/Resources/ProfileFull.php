<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileFull extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'first_name' => $this->ma_vorname,
            'name' => $this->ma_name,
            'name_2' => $this->ma_name_2,
            'employee_number' => $this->ma_nummer,
            'date_birth' => $this->ma_geburtsdatum,
            'date_entry' => $this->ma_eingetreten,
            'date_leave' => $this->ma_ausgetreten,
            'phone' => $this->ma_telefon,
            'mobile' => $this->ma_mobil,
            'fax' => $this->ma_fax,
            'com_1' => $this->ma_com_1,
            'com_2' => $this->ma_com_2,
        ];
    }
}
