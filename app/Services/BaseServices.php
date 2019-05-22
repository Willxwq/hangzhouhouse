<?php

namespace App\Services;

use App\Lib\ElogService;

class BaseServices
{
    use ElogService;

    public static function conversionData($x, $y)
    {
        $res['x'] = $x;
        $res['y'] = $y;

        return $res;
    }
}
