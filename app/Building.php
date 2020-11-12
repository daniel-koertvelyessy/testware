<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Stellplatz;
use DB;

class Building extends Model
{
    use SoftDeletes;
    /**
     * Returns the path of the page
     * @return string
     */

    protected $guarded = [];

    public function search($term) {
        return Building::where('b_name_kurz', 'like', '%' . $term . '%')
            ->orWhere('b_name_ort', 'like', '%' . $term . '%')
            ->orWhere('b_name_lang', 'like', '%' . $term . '%')
            ->orWhere('b_name_text', 'like', '%' . $term . '%')
            ->orWhere('b_we_name', 'like', '%' . $term . '%')
            ->get();
    }

    public function path()
    {
        return route('building.show', $this);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function BuildingType()
    {
        return $this->belongsTo(BuildingTypes::class);
    }

    public function getRooms($locid)
    {
        $list = DB::select('SELECT * from rooms where building_id =  ?', [$locid]);
        return count($list);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function countStellPlatzs(Building $building)
    {
        $n=0;
        foreach($building->rooms->pluck('id') as $rid){
            $n+= count(Stellplatz::where('room_id',$rid)->get());
        }
        return $n;
    }

    }
