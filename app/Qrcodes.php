<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use QRcode;

class Qrcodes extends Model
{

    static function makeQRCode($size,$value)
    {
        return QrCode::size($size)->generate($value);

    }



}
