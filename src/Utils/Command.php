<?php

namespace Overlu\Reget\Utils;


class Command
{
    /**
     * @param string $process 进程名称
     * @return array
     */
    public static function pid(string $process): array
    {
        $result = static::exec("ps -ef | grep '" . $process . "' | grep -v grep | awk '{print $2}'");
        $pids = array_filter(explode(',', str_replace("\n", ',', $result)));
        return $pids;
    }

    /**
     * @return bool
     */
    public static function checkSupervisord(): bool
    {
        return !empty(static::pid('supervisord'));
    }

    /**
     * 执行shell脚本
     * @param string $shell
     * @return string|null
     */
    public static function exec(string $shell)
    {
        return @shell_exec($shell);
    }

    /**
     * @param string $process
     */
    public static function kill(string $process): void
    {
        $pids = static::pid($process);
        if (!empty($pids)) {
            foreach ($pids as $pid) {
                static::exec('kill -9 ' . $pid);
            }
        }
    }

    /**
     * print info message
     * @param $message
     */
    public static function info($message)
    {
        static::out($message, 'success');
    }

    /**
     * print error message
     * @param $message
     */
    public static function error($message)
    {
        static::out($message, 'error');
    }

    /**
     * print warning message
     * @param $message
     */
    public static function warning($message)
    {
        static::out($message, 'warning');
    }

    /**
     * print default message
     * @param $message
     */
    public static function line($message)
    {
        static::out($message);
    }

    public static function suggest($message)
    {
        static::out($message, 'suggest');
    }

    /**
     * print message
     * @param $message
     * @param null $style
     * @param bool $newLine
     */
    public static function out($message, $style = null, $newLine = true)
    {
        $styles = [
            'success' => "\033[0;32m%s\033[0m",
            'error' => "\033[41;37m%s\033[0m",
            'warning' => "\033[43;37m%s\033[0m",
            'suggest' => "\033[44;37m%s\033[0m",
        ];
        $format = $styles[$style] ?? '%s';
        $format .= $newLine ? PHP_EOL : '';
        printf($format, $message);
    }
}
