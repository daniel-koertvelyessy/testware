<?php

namespace App;

class helpers
{
    // Snippet from PHP Share: http://www.phpshare.org
    public static function fileSizeForHumans($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 1, ',', '.').' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 1, ',', '.').' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 1, ',', '.').' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes.' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes.' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
