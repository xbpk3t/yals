<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        //七牛云
        'qiniu' => [
            'driver' => 'qiniu',
            'domains' => [
                'default' => env('QN_DOMAIN'),
                'https' => env('QN_HTTPS'),
                'custom' => '',
            ],
            'access_key' => env('QN_ACCESS'),  //AccessKey
            'secret_key' => env('QN_SECRET'),  //SecretKey
            'bucket' => env('QN_BUCKET'),  //Bucket名字
            'notify_url' => env('QN_NOTIFY'),  //持久化处理回调地址
        ],

        'oss' => [
                'driver' => 'oss',
                'access_id' => env('OSS_ACCESS_ID'),
                'access_key' => env('OSS_ACCESS_KEY'),
                'bucket' => env('oss_bucket'),
                'endpoint' => env('OSS_ENDPOINT'), // OSS 外网节点或自定义外部域名
                //'endpoint_internal' => '<internal endpoint [OSS内网节点] 如：oss-cn-shenzhen-internal.aliyuncs.com>', // v2.0.4 新增配置属性，如果为空，则默认使用 endpoint 配置(由于内网上传有点小问题未解决，请大家暂时不要使用内网节点上传，正在与阿里技术沟通中)
                'cdnDomain' => env('OSS_DOMAIN'), // 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
                'ssl' => env('OSS_SSL', false), // true to use 'https://' and false to use 'http://'. default is false,
                'isCName' => env('OSS_IS_CNAME', false), // 是否使用自定义域名,true: 则Storage.url()会使用自定义的cdn或域名生成文件url， false: 则使用外部节点生成url
                'debug' => env('OSS_DEBUG', true),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
