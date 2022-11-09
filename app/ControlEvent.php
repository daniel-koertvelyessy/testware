<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlEvent extends Model
{
    protected $guarded = [];

//    protected $table = 'equipments';

    use SoftDeletes;

    public function Equipment() {
        return $this->belongsTo(Equipment::class, 'control_equipment_id');
    }

    public function ControlEquipment() {
        return $this->belongsTo(ControlEquipment::class);
    }

    public function Requirement()
    {
        return $this->belongsTo(Anforderung::class);
    }

    public function ControlEventItem() {
        return $this->hasMany(ControlEventItem::class);
    }

    public static function makeControlEventReport($id) {
//      echo  view('pdf.html.control_event_report',['controlEvent'=>ControlEvent::find($id)]);
        $reportNo = (new TestReportFormat)->makeTestreportNumber($id);
        $data['html'] = view('pdf.html.control_event_report',['controlEvent'=>ControlEvent::find($id),'reportNo'=>$reportNo])->render();
        $data['id'] = $id;
        return $data;

    }

}
