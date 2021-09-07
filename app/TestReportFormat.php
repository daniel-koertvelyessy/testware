<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReportFormat extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function makeTestreportNumber($num)
    {
        $format = TestReportFormat::find(1);
        return $format->prefix . str_pad($num,$format->digits??6,'0',STR_PAD_LEFT) .  $format->postfix;
    }
}
