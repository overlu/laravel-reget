<?php


namespace Overlu\Reget\Drivers;

use Overlu\Reget\Driver;
use Overlu\Reget\Utils\Request;

class Nacos implements Driver
{
    use Base;
    protected $instance_uri = '/nacos/v1/ns/instance';
    protected $heartbeat_uri = '/nacos/v1/ns/instance/beat';
    protected $serverlist_uri = '/nacos/v1/ns/service/list';
    protected $instancelist_uri = '/nacos/v1/ns/instance/list';

    public function init()
    {
        $config = $this->config;
        $this->host = $config['register_host']; // 配置中心地址
        unset($config['register_host']);
        $this->service = $config;
    }

    /**
     * @return bool|mixed|string
     */
    public function register()
    {
        return Request::post($this->host . $this->instance_uri, $this->service);
    }

    public function heartbeat()
    {
        $params = [
            'serviceName' => $this->service['serviceName'],
//            'beat' => json_encode($this->service, JSON_UNESCAPED_UNICODE)
            'beat' => $this->service
        ];
        return Request::put($this->host . $this->heartbeat_uri, $params);
    }

    public function lists()
    {

        return Request::get($this->host . $this->instance_uri, $this->service);
    }

    public function servers()
    {
        return Request::get($this->host . $this->serverlist_uri, [
            'pageNo' => 1,
            'pageSize' => 99999
        ]);
    }

    public function server($service_name)
    {
        return Request::get($this->host . $this->instancelist_uri, [
            'serviceName' => $service_name
        ]);
    }

    public function config()
    {
        // TODO: Implement config() method.
    }

    public function delete()
    {
        return Request::delete($this->host . $this->instance_uri, $this->service);
    }


}
