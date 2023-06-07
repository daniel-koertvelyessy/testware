<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ProduktParam extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function Produkt()
    {
        return $this->belongsTo(Produkt::class);
    }

    /**
     * @param Request $request
     * @return $this // new or existing ProduktParam object
     */
    public function makeNewParameter(Request $request): ProduktParam
    {
        $checkParameterExists = ProduktParam::where([
            ['pp_label',$request->pp_label],
            ['produkt_id',$request->produkt_id]
        ]);
        if ($checkParameterExists->count()>0)return $checkParameterExists->first();
        $this->pp_label = $request->pp_label;
        $this->pp_name = $request->pp_name;
        $this->pp_value = $request->pp_value;
        $this->produkt_id = $request->produkt_id;
        $this->save();
        return $this;
    }

    public function addParam(
        String $pp_label,
        string $pp_name,
        string $pp_value,
        int $produkt_id
    ):bool
    {

        $this->pp_label = $pp_label;
        $this->pp_name = $pp_name;
        $this->pp_value = $pp_value;
        $this->produkt_id = $produkt_id;
        return $this->save();

    }

}
