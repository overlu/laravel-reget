<?php

namespace Overlu\Reget;

use Illuminate\Support\ServiceProvider;
use Overlu\Reget\Console\Heartbeat;
use Overlu\Reget\Console\Instance;
use Overlu\Reget\Console\Listen;
use Overlu\Reget\Console\Lists;
use Overlu\Reget\Console\Register;
use Overlu\Reget\Console\Remove;

class RegetServiceProvider extends ServiceProvider
{
    protected $defer = true; // 延迟加载服务

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('reget', function ($app) {
            return Reget::getInstance();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/reget.php' => config_path('reget.php'), // 发布配置文件到 laravel 的config 下
            __DIR__.'/Listeners/ConfigChangedShouldDoSomething.php' => app_path('Listeners/ConfigChangedShouldDoSomething.php')
        ]);
        $this->commands([Register::class, Heartbeat::class, Remove::class, Lists::class, Listen::class, Instance::class]);
    }

    public function provides()
    {
        return ['reget'];
    }
}
