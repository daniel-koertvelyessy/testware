<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlEvent extends Model
{
    protected $guarded = [];

//    protected $table = 'equipments';

    use SoftDeletes;

    public function search($term) {
        return ControlEvent::where('control_event_text', 'like', '%' . $term . '%')
            ->orWhere('control_event_supervisor_name', 'like', '%' . $term . '%')
            ->orWhere('control_event_controller_name', 'like', '%' . $term . '%')
            ->get();
    }

    public function Equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function ControlEquipment() {
        return $this->belongsTo(ControlEquipment::class);
    }

    public function ControlEventItem() {
        return $this->hasMany(ControlEventItem::class);
    }

    public static function makeControlEventReport($id) {
//      echo  view('pdf.html.control_event_report',['controlEvent'=>ControlEvent::find($id)]);

        $data['html'] = view('pdf.html.control_event_report',['controlEvent'=>ControlEvent::find($id)])->render();
        $data['id'] = $id;
        return $data;

    }

}
