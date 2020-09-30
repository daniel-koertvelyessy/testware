<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Building;
use DB;

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

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function fetchAddress()
    {
        return $this->belongsTo(Address::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
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
