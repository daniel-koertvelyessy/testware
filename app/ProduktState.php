<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduktState extends Model
{
    public function Produkt()
    {
        return $this->hasMany(Produkt::class);
 }

    public function apiAdd(Array $data)
    :int
    {
        if (ProduktState::where('ps_label',$data['label'])->count() > 0){
            return ProduktState::where('ps_label',$data['label'])->first()->id;
        }
        $this->ps_label = $data['label'];
        $this->ps_name = isset($data['name']) ? $data['name'] : NULL;
        $this->ps_color = isset($data['color']) ? $data['color'] : 'info' ;
        $this->ps_icon = isset($data['icon']) ? $data['icon'] : 'fas fa-info-circle';
        $this->ps_description = isset($data['description']) ?  $data['description'] : NULL;
        $this->save();
        return $this->id;

    }

    public function apiCheck(int $id)
    :int
    {
        return (ProduktState::where('id',$id)->count() >0) ? $id : 0;
    }
}
