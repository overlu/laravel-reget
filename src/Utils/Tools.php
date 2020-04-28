<?php


namespace Overlu\Reget\Utils;


class Tools
{
    /**
     * json 格式化
     * @param $json
     * @return string
     */
    public static function json_pretty($json): string
    {
        if (is_array($json)) {
            return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        $json = json_decode($json, true);
        return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
