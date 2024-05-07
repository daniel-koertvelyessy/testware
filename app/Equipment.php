<?php

    namespace App;

    use DB;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Request;
    use Kyslik\ColumnSortable\Sortable;

    class Equipment extends Model
    {
        public array $sortable = [
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

//        protected $with = ['Produkt'];

        //    protected $table = 'equipments';

        use SoftDeletes, Sortable, HasFactory;

        protected $guarded = [];

        public static function boot()
        {
            parent::boot();
            static::saving(function (Equipment $equipment)
            {
                Cache::forget('app-get-current-amount-Equipment');
                Cache::forget('system-status-database');
                Cache::forget('system-status-objects');

            });
            static::updating(function (Equipment $equipment)
            {
                Cache::forget('app-get-current-amount-Equipment');
                Cache::forget('system-status-database');
                Cache::forget('system-status-objects');

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

        /**
         * Get the route key for the model.
         *
         * @return string
         */
        public function getRouteKeyName()
        {
            return 'eq_uid';
//            return 'eq_inventar_nr';
        }

        public function Produkt()
        {
            return $this->belongsTo(Produkt::class);
        }
        public function isControlProdukt(Equipment $equipment)
        {

            $produkt = $equipment->Produkt;

            return ControlProdukt::where('produkt_id', $produkt->id)->get();

        }

        public function requirement(Produkt $produkt)
        {
            return ProduktAnforderung::with('Anforderung')->where('produkt_id',$produkt->id)->get()->map(function($produktAnforderung){
                return $produktAnforderung->Anforderung;
            });
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

        public function showStatus(): string
        {
            return '<span class="' . $this->EquipmentState->estat_icon . ' text-' . $this->EquipmentState->estat_color . '"></span>';
        }

        public function priceTag(): string
        {
//        return (float)$this->eq_price;
            return number_format($this->eq_price, 2, '.', '');
        }

        public function storage(): BelongsTo
        {
            return $this->belongsTo(Storage::class);
        }

        public function getStorageLabel()
        {
          return  Storage::findOrFail($this->storage_id)->storage_label;
        }

        public function control(): HasMany
        {
            return $this->hasMany(ControlEvent::class);
        }

        public function ControlEquipment(): HasMany
        {
            return $this->hasMany(ControlEquipment::class);
        }

        public function Anforderung(){
            return $this->hasManyThrough(Anforderung::class,ProduktAnforderung::class,'produkt_id','id','produkt_id');
        }

        public function EquipmentUid()
        {
            return $this->hasOne(EquipmentUid::class);
        }

        public function hasUser()
        {
            return $this->hasManyThrough(User::class, EquipmentQualifiedUser::class);
        }

        /**
         * @param Equipment $equipment
         *
         * @return bool
         */
        public function lockEquipment(Equipment $equipment): bool
        {
            $equipment->equipment_state_id = 4;
            return $equipment->save();
        }

        public function EquipmentQualifiedUser()
        {
            return $this->hasMany(EquipmentQualifiedUser::class);
        }

        public function qualifiedUserList(Equipment $equipment)
        {

            $userList = [];
            if ($equipment->countQualifiedUser() > 0)
                foreach ($equipment->EquipmentQualifiedUser as $quUser) {
                    $userList[] = User::find($quUser->user_id);
                }

            return $userList;

        }

        public function countQualifiedUser()
        {
            return $this->EquipmentQualifiedUser->count();
        }

        public function addInstructedUser(Request $request)
        {
            return EquipmentInstruction::create($request->validate([
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
            return (ControlProdukt::where('produkt_id',$this->produkt_id)->first())
                ? '<i class="fas fa-check text-success"></i>'
                : '<i class="fas fa-times text-muted"></i>';
        }

        public function addNew(Request $request)
        {

        }

        public function hasFunctionTest(): bool
        {
            return EquipmentFuntionControl::where('equipment_id', $this->id)->count() > 0;
        }

        static public function countInstances(Equipment $equipment){
            return Equipment::where('produkt_id',$equipment->produkt_id)->count();
        }

    }
