<?php

$api = app('Dingo\Api\Routing\Router');

$params = [
    'prefix' => 'api',
    'version' => 'v1.0',
    'namespace' => 'Modules\Common\Controllers',
];

$api->group($params, function ($api) {
    // 不需要登录的接口
    $api->group([
        'middleware' => ['api.throttle'],
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        $api->post('/sms', 'SmsLogController@sendSms');
        $api->post('/upload', 'UploadFileController@upload');
    });

    // 登录后才能使用的接口
    $api->group([
        // jwt中间件
        'middleware' => ['jwt.auth'],
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
    });
});
