<?php

namespace Overlu\Reget\Listeners;

class ConfigListener
{
    /**
     * @var array
     * Class @ method(default=handle)
     */
    protected static $observers = [];

    /**
     * @param $observer
     */
    public static function add($observer): void
    {
        static::$observers[] = $observer;
    }

    /**
     * @param $observer
     * @return bool
     */
    public static function delete($observer): bool
    {
        foreach (static::$observers as $key => $obs) {
            if ($obs == $observer) {
                unset(static::$observers[$key]);
                return true;
            }
        }
        return false;
    }

    /**
     * 通知
     */
    public static function notify(): void
    {
        foreach (static::$observers as $observer) {
            call_user_func_array([$observer, 'handle'], func_get_args());
        }
    }

    /**
     * 通知错误
     */
    public static function error(): void
    {
        foreach (static::$observers as $observer) {
            call_user_func_array([$observer, 'error'], func_get_args());
        }
    }

    /**
     * @return array
     */
    public static function observers(): array
    {
        return static::$observers;
    }
}
