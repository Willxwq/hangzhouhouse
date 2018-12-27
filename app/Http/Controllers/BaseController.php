<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\DataFormatService;
use App\Lib\ElogService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use DataFormatService;
    use ElogService;

    public static function conversionData($x, $y)
    {
        $res['x'] = $x;
        $res['y'] = $y;

        return $res;
    }

    //格式列表数据
    public static function formatDate($resultData)
    {
        $request = new Request();
        $total = isset($resultData['total']) ? $resultData['total'] : 0;
        $data = isset($resultData['rows']) ? $resultData['rows'] : array();
        $returnData = array(
            'draw' => $request->get('draw'),   //查询次数
            'recordsTotal' => $total,                //查询总数
            'recordsFiltered' => $total,             //table总数
            'data' => array_values($data)
        );
        die(json_encode($returnData));
    }
}
