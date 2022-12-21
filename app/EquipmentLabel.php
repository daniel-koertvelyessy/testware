<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class EquipmentLabel extends Model
{
    protected $guarded=[];

    protected $casts=[
        'show_labels' => 'boolean',
        'show_inventory' => 'boolean',
        'show_location' => 'boolean',
    ];

    /**
     * @param  Request  $request
     *
     * @return bool
     */
    public function add(Request $request)
    : bool {
        $this->label = $request->label;
        $this->name = $request->name;
        $this->show_labels = $request->show_labels;
        $this->show_inventory = $request->show_inventory;
        $this->show_location = $request->show_location;
        $this->label_w = $request->label_w;
        $this->Label_h = $request->Label_h;
        $this->label_ml = $request->label_ml;
        $this->label_mt = $request->label_mt;
        $this->label_mr = $request->label_mr;
        $this->qrcode_y = $request->qrcode_y;
        $this->qrcode_x = $request->qrcode_x;
        $this->logo_y = $request->logo_y;
        $this->logo_x = $request->logo_x;
        $this->logo_h = $request->logo_h;
        $this->logo_w = $request->logo_w;
        $this->logo_svg = $request->logo_svg;
        $this->tld_string = $request->tld_string;
        return $this->save();
    }

}
