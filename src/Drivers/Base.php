<?php

namespace Overlu\Reget\Drivers;


trait Base
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->init();
    }
}
