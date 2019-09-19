<?php
/**
 * 公共函数类库
 */
namespace App\Lib;

trait Common
{
    /**
     * 请求接口函数
     */
    public static function requestApi($url, $reqParam, $type = 'post')
    {
        $reqestUrl = $url;
        $reqParam = http_build_query($reqParam);
        $curl = new CommonCurl();
        $result = 'post' == $type ? $curl->post($reqestUrl, $reqParam) : $curl->get($reqestUrl . '?' . $reqParam);

        return $result;
    }
}