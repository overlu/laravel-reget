<?php


namespace Overlu\Reget\Utils;


use Illuminate\Support\Facades\Cache;

class ConfigCache
{
    /**
     * 写入本地配置
     * @param $dataId
     * @param $group
     * @param $content
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function set(string $dataId, string $group, string $content): bool
    {
        // key = dataId^2group^2tenant^1
        $char2 = pack('C*', 2);
        $key = $dataId . $char2 . $group . pack('C*', 1);
        return Cache::set($key, $content);
    }

    /**
     * 获取本地配置
     * @param string $dataId
     * @param string $group
     * @return mixed
     */
    public static function get(string $dataId, string $group)
    {
        $char2 = pack('C*', 2);
        $key = $dataId . $char2 . $group . pack('C*', 1);
        return Cache::get($key);
    }
}
