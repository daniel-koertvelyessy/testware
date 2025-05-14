<?php

    namespace App;

    use DB;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasManyThrough;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Collection;
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

        public static function boot(): void
        {
            parent::boot();
            static::saving(function ()
            {
               Equipment::clearCache();
            });
            static::updating(function ()
            {
               Equipment::clearCache();
            });
        }

        static function getControlEquipmentList(): Collection
        {
            return DB::table('equipment')->select('equipment.eq_inventar_nr', 'equipment.id', 'equipment.eq_name', 'produkts.prod_label')->join('produkts', 'equipment.produkt_id', '=', 'produkts.id')->join('control_produkts', 'equipment.produkt_id', '=', 'control_produkts.produkt_id')->get();
        }

        public function getControlProductData()
        {
            return $this->Produkt->ControlProdukt;
        }

        public function controlProdukte(): HasManyThrough
        {
            return $this->hasManyThrough(
                ControlProdukt::class,
                Produkt::class,
                'id',           // Foreign key on Produkt
                'produkt_id',   // Foreign key on ControlProdukt
                'produkt_id',   // Local key on Equipment
                'id'            // Local key on Produkt
            );
        }

        public function controlProdukt(): HasOne
        {
            return $this->hasOne(ControlProdukt::class, 'produkt_id', 'produkt_id');
        }

        /**
         * Get the route key for the model.
         *
         * @return string
         */
        public function getRouteKeyName(): string
        {
            return 'eq_uid';
//            return 'eq_inventar_nr';
        }

        public function Produkt(): BelongsTo
        {
            return $this->belongsTo(Produkt::class);
        }


        public function isControlProdukt():bool
        {

            if (is_null($this->produkt_id)) {
                return false;
            }

            return $this->relationLoaded('controlProdukte')
                ? $this->controlProdukte->isNotEmpty()
                : ControlProdukt::where('produkt_id', $this->produkt_id)->exists();

        }

        public function getIsTestedAttribute(): bool
        {
            return $this->tested_count > 0;
        }


        public function requirement(Produkt $produkt)
        {
            return ProduktAnforderung::with('Anforderung')->where('produkt_id',$produkt->id)->get()->map(function($produktAnforderung){
                return $produktAnforderung->Anforderung;
            });
        }

        public function produktDetails(): BelongsTo
        {
            return $this->belongsTo(Produkt::class, 'produkt_id', 'id', 'EquipmentDetails');
        }

        public function EquipmentParam(): HasMany
        {
            return $this->hasMany(EquipmentParam::class);
        }

        public function EquipmentState(): BelongsTo
        {
            return $this->belongsTo(EquipmentState::class);
        }

        public function EquipmentHistory(): HasMany
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


        public function Anforderung(): HasManyThrough
        {
            return $this->hasManyThrough(
                Anforderung::class,
                ProduktAnforderung::class,
                'produkt_id', // Foreign key on ProduktAnforderung
                'id',         // Foreign key on Anforderung
                'produkt_id', // Local key on Equipment
                'anforderung_id' // Local key on Equipment
            );
        }

        public function EquipmentUid(): HasOne
        {
            return $this->hasOne(EquipmentUid::class);
        }

        public function hasUser(): HasManyThrough
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

        public function EquipmentQualifiedUser(): HasMany
        {
            return $this->hasMany(EquipmentQualifiedUser::class);
        }

        public function qualifiedUserList(Equipment $equipment): Collection
        {

            return $equipment->EquipmentQualifiedUser()->with('user')->get()->pluck('user');

        }

        public function countQualifiedUser(): int
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


        public function controlProductIcon():string
        {
            return $this->isControlProdukt()
                ? '<i class="fas fa-check text-success"></i>'
                : '<i class="fas fa-times text-muted"></i>';
        }

        public function hasFunctionTest(): bool
        {
            return EquipmentFuntionControl::where('equipment_id', $this->id)->count() > 0;
        }

        static public function countInstances(Equipment $equipment): int
        {
            return Equipment::where('produkt_id',$equipment->produkt_id)->count();
        }

     public static function clearCache(): void
        {
            Cache::forget('app-get-current-amount-Equipment');
            Cache::forget('system-status-database');
            Cache::forget('system-status-objects');
            Cache::forget('equipment.count');
        }


    }
