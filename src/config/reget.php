<?php
return [
    'driver' => 'nacos',
    'nacos' => [
        'register_host' => env('NACOS_REGISTER_HOST', 'http://127.0.0.1:8848'),  // 注册中心地址
        'ip' => env('NACOS_SERVICE_HOST', '127.0.0.1'),  // 服务IP
        'port' => env('NACOS_SERVICE_PORT', '80'), // 服务port
        'namespaceId' => env('NACOS_SERVICE_NAMESPACEID',''), // 命名空间ID
        'weight' => env('NACOS_SERVICE_WEIGHT','1.0'),  // 权重
        'enabled' => env('NACOS_SERVICE_ENABLE','true'),  // 是否上线
        'healthy' => env('NACOS_SERVICE_HEALTHY','true'),  // 是否健康
        'metadata' => env('NACOS_SERVICE_METADATA',''),  // 扩展信息
        'clusterName' => env('NACOS_SERVICE_CLUSTERNAME',''),  // 集群名
        'serviceName' => env('NACOS_SERVICE_NAME', '服务名'), // 服务名
        'groupName' => env('NACOS_SERVICE_GROUPNAME',''),  // 分组名
        'ephemeral' => env('NACOS_SERVICE_EPHEMERAL','false'), // 是否临时实例
        'scheduled' => env('NACOS_SERVICE_SCHEDULED','true')
    ]
];
