<?php

namespace App\Helpers\Validation;

class ValidateDate
{
    public static function execute($date, $format = 'Y-m-d'): bool
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }
}