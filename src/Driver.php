<?php


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
     * 心跳
     * @return mixed
     */
    public function heartbeat();
}
