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
<?php
return [
    'driver' => 'nacos',
    'nacos' => [
        'register_host' => env('NACOS_REGISTER_HOST', 'http://127.0.0.1:8848'),
        'ip' => env('NACOS_SERVICE_HOST', '127.0.0.1'),   // 服务实例IP
        'port' => env('NACOS_SERVICE_PORT', 8081), // 服务实例port
        'namespaceId' => env('NACOS_SERVICE_NAMESPACEID',''), // 命名空间ID
        'weight' => env('NACOS_SERVICE_WEIGHT',''),  // 权重
        'enabled' => env('NACOS_SERVICE_ENABLE',true),  // 是否上线
        'healthy' => env('NACOS_SERVICE_HEALTHY',true),  // 是否健康
        'metadata' => env('NACOS_SERVICE_METADATA',''),  // 扩展信息
        'clusterName' => env('NACOS_SERVICE_CLUSTERNAME',''),  // 集群名
        'serviceName' => env('NACOS_SERVICE_NAME', 'server_name'), // 服务名
        'groupName' => env('NACOS_SERVICE_GROUPNAME',''),  // 分组名
        'ephemeral' => env('NACOS_SERVICE_EPHEMERAL',false), // 是否临时实例
        'scheduled' => env('NACOS_SERVICE_SCHEDULED',true)
    ]
];
```

#### Usage
* ##### 配置
修改配置文件`reget.php`，根据参数说明修改相关参数，或者`在.env文件中加入相关参数配置(建议)`

* ##### 获取服务
```php
$service=\Overlu\Reget\Reget::getInstance()->service('service_name');
return $service;
```
