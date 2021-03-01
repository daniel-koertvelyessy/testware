<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Kyslik\ColumnSortable\Sortable;

class Equipment extends Model
{
    public $sortable = [
        'id',
        'eq_inventar_nr',
        'eq_serien_nr',
        'installed_at',
        'purchased_at',
        'eq_price',
        'eq_uid',
        'eq_name',
        'produkt_id',
        'created_at',
        'updated_at'
    ];

    //    protected $table = 'equipments';

    use SoftDeletes, Sortable;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Equipment $equipment) {
            Cache::forget('app-get-current-amount-Equipment');
            Cache::forget('system-status-counter');

        });
        static::updating(function (Equipment $equipment) {
            Cache::forget('app-get-current-amount-Equipment');
            Cache::forget('system-status-counter');

        });
    }

    static function getControlEquipmentList()
    {
        return DB::table('equipment')->select('equipment.eq_inventar_nr', 'equipment.id', 'equipment.eq_name', 'produkts.prod_label')->join('produkts', 'equipment.produkt_id', '=', 'produkts.id')->join('control_produkts', 'equipment.produkt_id', '=', 'control_produkts.produkt_id')->get();
    }

    public function getControlProductData()
    {
        return $this->Produkt->ControlProdukt;
    }

    public function search($term)
    {
        return Equipment::where('eq_inventar_nr', 'like', '%' . $term . '%')->orWhere('eq_serien_nr', 'like', '%' . $term . '%')->orWhere('eq_inventar_nr', 'like', '%' . $term . '%')->orWhere('eq_text', 'like', '%' . $term . '%')->orWhere('eq_uid', 'like', '%' . $term . '%')->orWhere('eq_name', 'like', '%' . $term . '%')->get();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'eq_inventar_nr';
    }

    public function produkt()
    {
        return $this->belongsTo(Produkt::class);
    }

    public function produktDetails()
    {
        return $this->belongsTo(Produkt::class, 'produkt_id', 'id', 'EquipmentDetails');
    }

    public function EquipmentParam()
    {
        return $this->hasMany(EquipmentParam::class);
    }

    public function EquipmentState()
    {
        return $this->belongsTo(EquipmentState::class);
    }

    public function EquipmentHistory()
    {
        return $this->hasMany(EquipmentHistory::class);
    }

    public function showStatus()
    {
        return '<span class="' . $this->EquipmentState->estat_icon . ' text-' . $this->EquipmentState->estat_color . '"></span>';
    }

    public function priceTag()
    {
//        return (float)$this->eq_price;
        return number_format($this->eq_price, 2, '.', '');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function control()
    {
        return $this->hasMany(ControlEvent::class);
    }

    public function ControlEquipment()
    {
        return $this->hasMany(ControlEquipment::class);
    }

    public function EquipmentUid()
    {
        return $this->hasOne(EquipmentUid::class);
    }

    public function hasUser()
    {
        return $this->hasManyThrough('User', 'EquipmentQualifiedUser');
    }

    public function EquipmentQualifiedUser()
    {
        return $this->hasMany(EquipmentQualifiedUser::class);
    }


    public function countQualifiedUser()
    {
        return $this->EquipmentQualifiedUser->count();
    }

    public function addInstructedUser(Request $request)
    {
        return  EquipmentInstruction::create($request->validate([
            'equipment_instruction_date'                  => 'bail|required|date',
            'equipment_instruction_instructor_signature'  => '',
            'equipment_instruction_instructor_profile_id' => '',
            'equipment_instruction_instructor_firma_id'   => '',
            'equipment_instruction_trainee_signature'     => '',
            'equipment_instruction_trainee_id'            => 'required',
            'equipment_id'                                => 'required'
        ]));
    }


    public function isControlProduct()
    {
        return ($this->produkt->ControlProdukt) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-muted"></i>';
    }

    public function addNew(Request $request)
    {

    }
}
