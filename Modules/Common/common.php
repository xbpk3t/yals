<?php

$api = app('Dingo\Api\Routing\Router');

$params = [
    'prefix' => 'common',
    'version' => 'v1.0',
    'namespace' => 'Modules\Common\Controllers',
    'limit' => config('api.rate_limits.sign.limit'),
    'expires' => config('api.rate_limits.sign.expires'),
];
$middleware1 = ['middleware' => [
    'api.throttle',
    'aes.encrypt',
    'aes.decrypt'
]];
$middleware2 = ['middleware' => [
    'api.throttle',
    'jwt.auth'
]];

$api->group(array_merge($params, $middleware1), function ($api) {
    // 不需要登录的接口
    $api->get('/hello', 'BaseController@hello');
    $api->post('/world', 'BaseController@world');
    $api->post('/sms', 'SmsLogController@sendSms');
    $api->post('/upload', 'UploadFileController@upload');
});

// 登录后才能使用的接口
$api->group(array_merge($params, $middleware2), function ($api) {
});
