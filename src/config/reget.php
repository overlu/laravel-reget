<?php
return [
    'driver' => 'nacos',
    'nacos' => [
        'register_host' => env('NACOS_REGISTER_HOST', 'http://127.0.0.1:8848'),
        'ip' => env('NACOS_SERVICE_HOST', ''),   // 服务实例IP
        'port' => env('NACOS_SERVICE_PORT', ''), // 服务实例port
        'namespaceId' => env('NACOS_SERVICE_NAMESPACE_ID', ''), // 命名空间ID
        'weight' => env('NACOS_SERVICE_WEIGHT', '0.8'),  // 权重
        'enabled' => env('NACOS_SERVICE_ENABLE', 'true'),  // 是否上线
        'healthy' => env('NACOS_SERVICE_HEALTHY', 'true'),  // 是否健康
        'metadata' => env('NACOS_SERVICE_METADATA', '{}'),  // 扩展信息 json
        'clusterName' => env('NACOS_SERVICE_CLUSTER_NAME', 'DEFAULT'),  // 集群名
        'serviceName' => env('NACOS_SERVICE_NAME', 'server_name'), // 服务名
        'groupName' => env('NACOS_SERVICE_GROUP_NAME', 'DEFAULT_GROUP'),  // 分组名
        'ephemeral' => env('NACOS_SERVICE_EPHEMERAL', 'true'), // 是否临时实例
        'scheduled' => env('NACOS_SERVICE_SCHEDULED', 'true')
    ]
];
