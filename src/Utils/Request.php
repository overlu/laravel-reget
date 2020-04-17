<?php

namespace Overlu\Reget\Utils;

use GuzzleHttp\Client;

class Request
{
//    protected static $headers = ["Content-type:application/json;charset='utf-8'", "Accept:application/json"];
    protected static $headers = ["Content-type:text/plain;charset=UTF-8"];

    /**
     * post请求
     * @param string $url
     * @param array $data
     * @return bool|mixed|string
     */
    public static function post(string $url, array $data = [])
    {
        $result = (new Client([
            'timeout' => 5.0
        ]))->request('POST', $url, [
            'form_params' => $data,
        ]);
        return $result->getBody()->getContents();
    }

    /**
     * delete请求
     * @param string $url
     * @param array $data
     * @return bool|mixed|string
     */
    public static function delete(string $url, array $data = [])
    {
        $result = (new Client([
            'timeout' => 5.0
        ]))->request('DELETE', $url, [
            'form_params' => $data,
        ]);
        return $result->getBody()->getContents();
    }

    /**
     * get请求
     * @param string $url
     * @return bool|mixed|string
     */
    public static function get(string $url, array $data = [])
    {
        $result = (new Client([
            'timeout' => 5.0
        ]))->request('GET', $url, [
            'query' => $data,
        ]);
        return $result->getBody()->getContents();
    }

    /**
     * put请求
     * @param string $url
     * @return bool|mixed|string
     */
    public static function put(string $url, array $data = [])
    {
        $url = $data ? $url . '?' . http_build_query($data) : $url;
        $result = (new Client([
            'timeout' => 5.0
        ]))->request('PUT', $url);
        return $result->getBody()->getContents();
    }
}
