<?php

namespace App\Lib;

class MessageCode
{
    public static $codes = [
        // 全局
        200 => ['error' => 'Success', 'message' => '成功'],
        401 => ['error' => 'Unauthorized', 'message' => '未授权'],
        500 => ['error' => 'System Error', 'message' => '系统错误'],
        505 => ['error' => 'Params Validation Error', 'message' => '参数验证错误'],
        506 => ['error' => 'Process Fail', 'message' => '处理失败'],
        507 => ['error' => 'Get Data Fail', 'message' => '没有找到该记录'],
        508 => ['error' => 'No Permission', 'message' => '没有操作权限'],
    ];

    public static function getMessage($code)
    {
        return self::$codes[$code];
    }
}