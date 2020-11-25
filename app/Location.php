<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Building;
use DB;
use Illuminate\Support\Facades\Cache;

class Location extends Model
{

    use SoftDeletes;
    /*
 *
 *    Schütz nicht vor Injektionsangriffen!!!!


    protected $fillable = [
        'l_name_kurz',
        'l_name_lang',
        'l_beschreibung',
        'adress_id',
        'profile_id'
    ];

*/

    protected $guarded = [];

    public static function boot() {
        parent::boot();
        static::saving(function (Location $location) {
            Cache::forget('app-get-current-amount-Location');
        });
        static::updating(function (Location $location) {
            Cache::forget('app-get-current-amount-Location');
        });
    }

    public function search($term) {
        return Location::where('l_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('l_name_lang', 'like', '%' . $term . '%')
            ->orWhere('l_beschreibung', 'like', '%' . $term . '%')
            ->get();
    }

    /**
     * Returns the path of the page
     * @return string
     */
    public function path()
    {
        return route('location.show', $this);
    }

    public function getBuildings($locid)
    {
        $list = DB::select('SELECT * from buildings where locations_id=?', [$locid]);
        // dd($list);

        return count($list);

        // return $this->hasMany(Building::class);
        // return $list;
    }

    public function getequipment($equipmenttype = 1)
    {
        // gibt alle Geräte des Standortes zurück
        // mit $equipmenttype kann die Art der Geräte gefiltert werden
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

    public function LocationAnforderung()
    {
        return $this->hasMany(LocationAnforderung::class);
    }

    static function checkStatus()
    {
        if (rand(1,3) === 1)
        {
            return '
                    <span class="sectionStatus">
                        Status <i class="fas fa-check-circle text-success"></i>
                    </span>
                    ';
        } elseif (rand(1,3) === 2) {
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
}
