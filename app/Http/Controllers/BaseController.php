<?php

namespace App\Http\Controllers;

use App\Lib\Common;
use App\Lib\DataFormatService;
use App\Lib\ElogService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use DataFormatService;
    use ElogService;
    use Common;

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

    /**
     * 生成UUID
     * @param string $prefix 前缀
     * @return string UUID
     */
    function create_uuid($prefix = "")
    {    //可以指定前缀
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8);
        $uuid .= substr($str, 8, 4);
        $uuid .= substr($str, 12, 4);
        $uuid .= substr($str, 16, 4);
        $uuid .= substr($str, 20, 12);
        return $prefix . $uuid;
    }
}
