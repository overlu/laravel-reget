<?php declare(strict_types=1);
namespace Overlu\Reget;

interface Driver
{
    /**
     * 初始化
     * @return mixed
     */

    public function init();

    /**
     * 注册服务
     * @return mixed
     */
    public function register();


    /**
     * 获取配置
     * @return mixed
     */
    public function config();

    /**
     * 心跳
     * @return mixed
     */
    public function heartbeat();
}
