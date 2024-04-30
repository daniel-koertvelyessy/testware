<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{

    use SoftDeletes, Sortable, HasFactory;

    public $sortable = [
        'l_label',
        'l_name',
        'l_beschreibung',
        'adresse_id',
        'profile_id'
    ];

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Location $location) {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
        static::updating(function (Location $location) {
            Cache::forget('app-get-current-amount-Location');
            Cache::forget('countTotalEquipmentInLocation');
            Cache::forget('system-status-database');Cache::forget('system-status-objects');
        });
    }

    public function add(Request $request, int $adresse_id, int $profile_id)
    {
        $this->l_benutzt = $request->l_benutzt;
        $this->l_label = $request->l_label;
        $this->l_name = $request->l_name;
        $this->l_beschreibung = $request->l_beschreibung;
        $this->profile_id = $profile_id;
        $this->adresse_id = $adresse_id;
        $this->storage_id = $request->storage_id;
        $this->save();
        return $this->id;
    }

    public static function checkStatus()
    {
        if (rand(1, 3) === 1) {
            return '
                    <span class="sectionStatus">
                        Status <i class="fas fa-check-circle text-success"></i>
                    </span>
                    ';
        } elseif (rand(1, 3) === 2) {
            return '
                    <span class="sectionStatus">
                        Status <i class="fas fa-exclamation-circle text-warning"></i>
                    </span>
                    ';
        } else {
            return '
                    <span class="sectionStatus">
                        Status <i class="fas fa-times-circle text-danger"></i>
                    </span>
                    ';
        }
    }



    /**
     * Returns the path of the page
     *
     * @return string
     */
    public function path()
    {
        return route('location.show', $this);
    }

    public function Profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function Adresse()
    {
        return $this->belongsTo(Adresse::class);
    }

    public function Building()
    {
        return $this->hasMany(Building::class);
    }

    public function Storage()
    {
        return $this->hasOne(Storage::class, 'storage_uid', 'storage_id');
    }

    public function countTotalEquipmentInLocation()
        : int
    {
        return Cache::remember('countTotalEquipmentInLocation' . $this->id, now()->addSeconds(30), function () {
            $equipmenInLocationCounter = 0;
            $equipmenInLocationCounter += ($this->Storage) ? $this->Storage->countReferencedEquipment() : 0;
            foreach ($this->Building as $building) {
                $equipmenInLocationCounter += $building->countTotalEquipmentInBuilding();
            }
            return $equipmenInLocationCounter;
        });
    }
}
