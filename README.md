### 前言
#### 项目介绍
`overlu/laravel-reget` 是一款基于laravel的nacos扩展

#### 安装

``` php
php composer.phar require overlu/laravel-reget
# publish config
php artisan vendor:publish --provider="Overlu\Reget\RegetServiceProvider"
# laravel5.5以前，安装好Reget扩展后，打开 config/app.php，注册如下服务提供者到 $providers 数组：
Overlu\Reget\RegetServiceProvider::class
# 然后添加如下门面到 $aliaes 数组：
'Reget' => \Overlu\Reget\Facades\Reget::class
```

#### 配置
```php
<?php
return [
    'driver' => 'nacos',
    'nacos' => [
        'register_host' => env('NACOS_REGISTER_HOST', 'http://127.0.0.1:8848'),
        'ip' => env('NACOS_SERVICE_HOST', ''),   // 服务实例IP
        'port' => env('NACOS_SERVICE_PORT', ''), // 服务实例port
        'namespaceId' => env('NACOS_SERVICE_NAMESPACE_ID', ''), // 命名空间ID
        'weight' => env('NACOS_SERVICE_WEIGHT', 1),  // 权重
        'enabled' => env('NACOS_SERVICE_ENABLE', 'true'),  // 是否上线
        'healthy' => env('NACOS_SERVICE_HEALTHY', 'true'),  // 是否健康
        'metadata' => env('NACOS_SERVICE_METADATA', ''),  // 扩展信息 json
        'clusterName' => env('NACOS_SERVICE_CLUSTER_NAME', ''),  // 集群名
        'serviceName' => env('NACOS_SERVICE_NAME', 'server_name'), // 服务名
        'groupName' => env('NACOS_SERVICE_GROUP_NAME', ''),  // 分组名
        'ephemeral' => env('NACOS_SERVICE_EPHEMERAL', 'false'), // 是否临时实例
        'scheduled' => env('NACOS_SERVICE_SCHEDULED', 'true')
    ]
];
```
修改配置文件`reget.php`，根据参数说明修改相关参数，或者__`在.env文件中加入相关参数配置(建议)`__
> `ip`、`port`留空，系统会自动获取

#### Usage
##### 常用命令
```php
// 注册服务
php artisan reget:register
// 发送心跳
php artisan reget:heartbeat
// 查看服务列表
php artisan reget:list
// 移除服务
php artisan reget:remove
// 监听配置
php artisan reget:listen key
```
##### 定时发送心跳：
```php
// 1. 下面的 Cron 添加到你的服务器中
* * * * * cd /path-to-your-project && php artisan schedule:run >>/dev/null 2>&1
// 2. 在 App\Console\Kernel 类的 schedule 方法中定义所有的调度任务
protected function schedule(Schedule $schedule)
{
    $schedule->command('reget:heartbeat')->everyFiveMinutes();
}
```

##### 获取服务
```php
$service = \Overlu\Reget\Reget::getInstance()->service('service_name');
// or 
$service = Reget::service('service_name');
return $service;
```

##### 获取配置

#### API
