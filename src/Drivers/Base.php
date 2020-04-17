<?php


namespace Overlu\Reget\Drivers;


trait Base
{
    private $service;
    private $host;

    public function __construct($config)
    {
        $this->config = $config;
        $this->init();
    }
}
