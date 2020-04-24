<?php declare(strict_types=1);
namespace Overlu\Reget;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Reget
{
    private static $instance;
    private $drivers = [
        'nacos', 'consul', 'eureka'
    ];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return Reget
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    public function init()
    {
        try {
            $driver = $this->getDriver();
            $driver_name = Str::studly($driver);
            $driverClass = "\\Overlu\\Reget\\Drivers\\" . $driver_name;
            $config = $this->getConfig();
            return new $driverClass($config);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|null
     * @throws \Exception
     */
    private function getConfig()
    {
        return config('reget.' . $this->getDriver());
    }

    /**
     * 获取驱动
     * @return string
     * @throws \Exception
     */
    private function getDriver(): string
    {
        $driver = config('reget.driver');
        if (!in_array($driver, $this->drivers)) {
            throw new \Exception('illegal driver');
        }
        return $driver;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function lists()
    {
        $lists = json_decode($this->init()->servers(), true);
        if (!empty($lists)) {
            return $lists['doms'];
        }
    }


    /**
     * @param $name
     * @param bool $random
     * @return array|mixed|string|null
     * @throws \Exception
     */
    public function service($name, $random = true)
    {
        $lists = $this->lists();
        if (in_array($name, $lists)) {
            $hosts = json_decode($this->init()->server($name), true)['hosts'];
            if ($hosts) {
                if ($random) {
                    $host = Arr::random($hosts);
                    return $host['port'] == '80' ? $host['ip'] : $host['ip'] . ':' . $host['port'];
                }
                foreach ($hosts as $host) {
                    $temp[] = $host['port'] == '80' ? $host['ip'] : $host['ip'] . ':' . $host['port'];
                }
                return $temp;
            }
        }
        return null;
    }
}
