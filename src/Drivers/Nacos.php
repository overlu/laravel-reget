<?php


namespace Overlu\Reget\Drivers;

use Overlu\Reget\Driver;
use Overlu\Reget\Utils\Request;

class Nacos implements Driver
{
    use Base;

    private $service;
    private $host;

    //service
    protected $instance_uri = '/nacos/v1/ns/instance';
    protected $heartbeat_uri = '/nacos/v1/ns/instance/beat';
    protected $service_list_uri = '/nacos/v1/ns/service/list';
    protected $instance_list_uri = '/nacos/v1/ns/instance/list';

    //server
    protected $server_list_uri = '/nacos/v1/ns/operator/servers';

    // config
    protected $config_uri = '/nacos/v1/cs/configs';
    protected $config_listen_uri = '/nacos/v1/cs/configs/listener';


    public function init()
    {
        $config = $this->config;
        $this->host = $config['register_host']; // 配置中心地址
        unset($config['register_host']);
        $this->service = $config;
    }

    /**
     * 注册
     * @param array $server
     * @return mixed|string
     */
    public function register($server = [])
    {
        if (!empty($server)) {
            $this->service = $server + $this->service;
        }
        return Request::post($this->host . $this->instance_uri, $this->service);
    }

    /**
     * 集群Server列表
     * @return string
     */
    public function servers()
    {
        return Request::get($this->host . $this->server_list_uri, [
            'healthy' => 'true'
        ]);
    }

    public function instance(){
        return Request::get($this->host . $this->instance_uri, $this->service);
    }

    /**
     * 心跳
     * @return bool|mixed|string
     */
    public function heartbeat()
    {
        $keys = ["cluster", "ip", "metadata", "port", "scheduled", "serviceName", "weight"];
        $ser = $this->service;
        $ser['cluster'] = $ser['clusterName'];
        foreach ($ser as $key => $value) {
            if (!in_array($key, $keys)) {
                unset($ser[$key]);
            }
            if ($key == 'metadata') {
                $metadata = json_decode($ser[$key]);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $ser[$key] = (object)[];
                } else {
                    $ser[$key] = (object)$metadata;
                }
            }
        }
        $params = [
            'serviceName' => $this->service['serviceName'],
            'beat' => json_encode($ser)
        ];
        return Request::put($this->host . $this->heartbeat_uri, $params);
    }

    /**
     * 实例列表
     * @return bool|mixed|string
     */
    public function lists()
    {
        return Request::get($this->host . $this->instance_uri, $this->service);
    }

    /**
     * 服务列表
     * @return bool|mixed|string
     */
    public function services()
    {
        return Request::get($this->host . $this->service_list_uri, [
            'pageNo' => 1,
            'pageSize' => 99999
        ]);
    }

    /**
     * 服务详情
     * @param $service_name
     * @return bool|mixed|string
     */
    public function service($service_name)
    {
        return Request::get($this->host . $this->instance_list_uri, [
            'serviceName' => $service_name
        ]);
    }


    /**
     * 移除服务
     * @return bool|mixed|string
     */
    public function delete()
    {
        return Request::delete($this->host . $this->instance_uri, $this->service);
    }

    /*************************************** config ***************************************/

    /**
     * 获取配置信息
     * @param $dataId
     * @param string $group
     * @return bool|mixed|string
     */
    public function config($dataId, $group)
    {
        return Request::get($this->host . $this->config_uri, [
            'dataId' => $dataId,
            'group' => $group
        ]);
    }

    /**
     * @param $dataId
     * @param $content
     * @param string $group
     * @return bool|mixed|string
     */
    public function publish($dataId, $content, $group)
    {
        return Request::post($this->host . $this->config_uri, [
            'content' => $content,
            'dataId' => $dataId,
            'group' => $group
        ]);
    }

    /**
     * 移除配置信息
     * @param $dataId
     * @param string $group
     * @return bool|mixed|string
     */
    public function remove($dataId, $group)
    {
        return Request::delete($this->host . $this->config_uri, [
            'dataId' => $dataId,
            'group' => $group
        ]);
    }

    /**
     * 监听配置
     * @param string $dataId
     * @param string $content
     * @param string $group
     * @return string
     */
    public function listen(string $dataId, string $content, string $group)
    {
        // dataId^2Group^2contentMD5^2tenant^1
        $char2 = pack('C*', 2);
        return Request::post($this->host . $this->config_listen_uri, [
            'Listening-Configs' => $dataId . $char2 . $group . $char2 . md5($content) . pack('C*', 1)
        ], [
            'Long-Pulling-Timeout' => 30000
        ]);
    }

}
