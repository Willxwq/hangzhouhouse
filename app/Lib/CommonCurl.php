<?php

namespace App\Lib;
/**
 * http类
 * @package  htdocs
 * @version 1.0
 */

class CommonCurl
{
    public function post($url, $data, $http_opts = null, $headers = null)
    {

        if (!isset($url) || empty($url)) {
            return array('code' => 400, 'message' => '缺少请求链接');
        }
        if (!isset($data) || empty($data)) {
            return array('code' => 400, 'message' => '缺少请求参数');
        }
        //解析链接，判断请求协议
        $parse_url_array = parse_url($url);

        $curl_handler = curl_init();

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HEADER => false,
            CURLOPT_USERAGENT => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36',
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $data
        );


        if ($parse_url_array['scheme'] == 'https') {
            $options[CURLOPT_SSL_VERIFYPEER] = 0;
            $options[CURLOPT_SSL_VERIFYHOST] = 0;
            $options[CURLOPT_SSLVERSION] = 4;
        }

        if ($headers) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        if (is_array($http_opts)) {
            foreach ($http_opts as $key => $value) {
                $options[$key] = $value;
            }
        }

        curl_setopt_array($curl_handler, $options);
        $curl_result = curl_exec($curl_handler);

        $curl_http_status = curl_getinfo($curl_handler, CURLINFO_HTTP_CODE);


        if ($curl_result == false) {
            $error = curl_error($curl_handler);
            curl_close($curl_handler);
            return array( 'code' => $curl_http_status, 'message' => $error);
        }
        curl_close($curl_handler);


        $encode = mb_detect_encoding($curl_result, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        if ($encode != 'UTF-8') {
            $curl_result = iconv($encode, 'UTF-8', $curl_result);
        }

        $result = json_decode($curl_result, true);
        if (is_null($result)) {
            $result = $curl_result;
        }

        return $result;

    }


    public function get($url, $http_opts = null, $headers = array())
    {

        if (!isset($url) || empty($url)) {
            return array('code' => 400, 'message' => '缺少请求链接');
        }

        //解析链接，判断请求协议
        $parse_url_array = parse_url($url);

        $curl_handler = curl_init();

        // echo $url;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HEADER => true,
            // CURLOPT_USERAGENT       => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36',
        );

        if ($parse_url_array['scheme'] == 'https') {
            $options[CURLOPT_SSL_VERIFYPEER] = 0;
            $options[CURLOPT_SSL_VERIFYHOST] = 0;
            $options[CURLOPT_SSLVERSION] = 4;
        }
        if ($headers) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        if (is_array($http_opts)) {
            foreach ($http_opts as $key => $value) {
                $options[$key] = $value;
            }
        }
        curl_setopt_array($curl_handler, $options);
        $curl_result = curl_exec($curl_handler);
        $curl_http_status = curl_getinfo($curl_handler, CURLINFO_HTTP_CODE);
        if ($curl_result === false) {
            curl_close($curl_handler);
            return array('code' => 503, 'message' => '系统错误', 'data' => $curl_http_status);
        }
        $encode = mb_detect_encoding($curl_result, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        if ($encode != 'UTF-8') {
            $curl_result = iconv($encode, 'UTF-8', $curl_result);
        }
        if (is_string($curl_result)) {
            $list = (explode("\r\n\r\n", $curl_result));
            $result = json_decode($list[1] ?: $list[0], true) ;
        } else {
            $result = json_decode($curl_result, true);
        }

        if (is_null($result) || empty($result)) {
            $result = $curl_result;
        }

        curl_close($curl_handler);

        return $result;

    }
}