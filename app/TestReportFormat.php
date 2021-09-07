<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TestReportFormat extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function makeTestreportNumber($num)
    : string
    {
        $format = TestReportFormat::first();
        return ($format) ? $format->prefix . str_pad($num,$format->digits??6,'0',STR_PAD_LEFT) .  $format->postfix : $num;
    }

    public function add(Request $request)
    : bool
    {
        $this->prefix = $request->prefix;
        $this->digits = $request->digits;
        $this->postfix = $request->postfix;
        return $this->save();
    }
}
