<?php

namespace App\Traits;

use App\Models\Branch;

trait GeneratesUniqueCode
{
    public static function generateUniqueCode($lastCode, $prefix, $length = 4)
    {
        $lastNumber = $lastCode ? intval(substr($lastCode, strlen($prefix))) : 0;
        $nextNumber = $lastNumber + 1;
        $formattedNumber = str_pad($nextNumber, $length, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }
}
