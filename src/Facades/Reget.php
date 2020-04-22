<?php


namespace Overlu\Reget\Facades;


use Illuminate\Support\Facades\Facade;

class Reget extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reget';
    }

}