<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StellplatzTyp extends Model
{
    protected $guarded = [];

    public function stellplatz()
    {
        return $this->hasMany(Stellplatz::class);
    }

    public function checkApiCompartmentType(Request $request)
    {
        /**
         * Check if storage-type-id or storage-type-name is given and check if they exits
         */
        if (isset($request->compartment_type_id)) {
            $compartmentType = StellplatzTyp::find($request->compartment_type_id);
            if ($compartmentType) {
                return $request->compartment_type_id;
            } else {
                return false;
            }
        } elseif (isset($request->type['label'])) {
            $compartmentType = StellplatzTyp::where('spt_label', $request->type['label'])->first();
            if ($compartmentType) {
                return $compartmentType->id;
            } else {
                return $this->addAPICompartmentType($request);
            }
        } else {
            return 1;
        }
    }

    public function addAPICompartmentType(Request $request)
    {
        $this->spt_label = $request->type['label'];
        $this->spt_name = (isset($request->type['name'])) ? $request->type['name'] : null;
        $this->spt_description = (isset($request->type['description'])) ? $request->type['description'] : null;
        $this->save();

        return $this->id;
    }
}
