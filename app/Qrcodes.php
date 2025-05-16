<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use QRcode;

class Qrcodes extends Model
{
    public static function makeQRCode($size, $value)
    {
        return QrCode::size($size)->generate($value);

    }
}
