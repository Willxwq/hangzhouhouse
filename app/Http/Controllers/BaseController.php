<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\DataFormatService;
use App\Lib\ElogService;

class BaseController extends Controller
{
    use DataFormatService;
    use ElogService;

    public static function conversionData($data)
    {
        $res['x'] = array_column($data, 'x');
        $res['y'] = array_column($data, 'y');

        return $res;
    }
}
