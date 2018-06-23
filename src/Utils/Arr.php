<?php

namespace App\Utils;

class Arr
{
    public static function random(array $array)
    {
        return $array[mt_rand(0, \count($array) - 1)];
    }
}
