<?php

namespace App\Lib;

trait ElogService
{
    public static function elog($obj = null, $path = null)
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
