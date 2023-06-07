<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class ControlEvent extends Model
    {
        protected $guarded = [];

//    protected $table = 'equipments';

        use SoftDeletes;

        public function Equipment()
        {
            return $this->belongsTo(Equipment::class, 'control_equipment_id');
        }

        public function ControlEquipment()
        {
            return $this->belongsTo(ControlEquipment::class);
        }

        public function Requirement()
        {
            return $this->belongsTo(Anforderung::class);
        }

        public function ControlEventItem()
        {
            return $this->hasMany(ControlEventItem::class);
        }

        public static function makeControlEventReport($id)
        {
            $controlEvent = ControlEvent::findOrfail($id);
            $controlEquipment = ControlEquipment::withTrashed()->find($controlEvent->control_equipment_id);

            $reportNo = (new TestReportFormat)->makeTestreportNumber($id);

            $requirement = Anforderung::find($controlEquipment->anforderung_id);

            $data['html'] = view('pdf.html.control_event_report_modal', [
                'controlEvent'     => $controlEvent,
                'reportNo'         => $reportNo,
                'requirement'      => $requirement,
                'regulation'       => Verordnung::find($requirement->verordnung_id),
                'requirementitems' => AnforderungControlItem::where('anforderung_id', $requirement->id)->orderBy('aci_sort')->get(),
                'ControlEquipment' => $controlEquipment,
                'equipment'        => Equipment::find($controlEquipment->equipment_id),
                'aci_execution'    => AnforderungControlItem::where('anforderung_id', $controlEquipment->Anforderung->id)->first()
            ])->render();
            $data['id'] = $id;
            $data['header'] = __('Prüfbericht :num vom :dat', [
                'num' => $reportNo,
                'dat' => $controlEvent->control_event_date
            ]);
            return $data;

        }

    }
