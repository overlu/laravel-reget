<?php


namespace Overlu\Reget\Utils;


/**
 * Class ConfigData
 * @package Overlu\Reget\Utils
 */
class ConfigData
{
    private $key;
    /**
     * 原始数据
     * @var
     */
    private $originData;

    /**
     * 当前数据
     * @var
     */
    private $data;

    public function __construct($key, $data, $originData = null)
    {
        $this->setKey($key);
        $this->setData($data);
        $this->setOriginData($originData);
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key): void
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getOriginData()
    {
        return $this->originData;
    }

    /**
     * @param mixed $originData
     */
    public function setOriginData($originData): void
    {
        $this->originData = $originData;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
