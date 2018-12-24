<?php

namespace App\Lib;

use App\Lib\MessageCode;

trait DataFormatService
{
    protected static function format($code, $data = null, $message = null, $error = null)
    {
        $code = strval($code);
        $messageData = null;
        if (in_array($code, array_keys(MessageCode::$codes))) {
            $messageData = MessageCode::getMessage($code);
        }

        if (200 == $code) {
            return response()->json(
                $data,
                $code
            );
        } else {
            $path = \Request::path();
            $timestamp = time();

            $status = (401 == $code) ? $code : '409';
            if ($messageData) {
                $error = $messageData['error'];
                if (!$message) {
                    $message = $messageData['message'];
                }
            } else {
                $error = 'System Error';
                $message = '未知错误';
            }

            return response()->json(
                compact('code', 'status', 'error', 'message', 'data', 'path', 'timestamp'),
                $status
            );
        }
    }
}
