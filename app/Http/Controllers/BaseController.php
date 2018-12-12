<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    /**
     * 重写error_log 无参数时自动记录日志索引
     * 若要输出SQL 请在SQL方法执行前调用 elog('psql');
     * @param $obj   输出内容 或 null
     * @param $path 'D:/test.log' 或 null
     */
    static function elog($obj = null, $path = null)
    {
        //SQL日志
        if ($obj == 'sql') {
            global $di;
            $obj = $di->get('profiler')->getLastProfile()->getSQLStatement();
        }
        if (is_array($obj) || is_object($obj))
            $obj = print_r($obj, 1);
        elseif ($obj === null) {
            if (!isset($GLOBALS["logIndex"])) $GLOBALS["logIndex"] = 1;
            $obj = 'LOG--------------- ' . $GLOBALS["logIndex"];
            $GLOBALS["logIndex"]++;
        }
        $path ? error_log($obj, 3, $path) : error_log($obj);
    }
}
