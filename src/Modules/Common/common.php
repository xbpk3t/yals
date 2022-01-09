<?php

$api = app('Dingo\Api\Routing\Router');

$params = [
    'prefix' => 'common',
    'version' => 'v1.0',
    'namespace' => 'Modules\Common\Controllers',
];

$mwNotLogin = ['middleware' => [
    'api.throttle',
],
    'limit' => config('api.rate_limits.sign.limit'),
    'expires' => config('api.rate_limits.sign.expires'),
];

$mwLogin = ['middleware' => [
    'api.throttle',
    'jwt.auth',
],
    'limit' => config('api.rate_limits.sign.limit'),
    'expires' => config('api.rate_limits.sign.expires'),
];

// 不需要登录的接口
$api->group(array_merge($params, $mwNotLogin), function ($api) {

    $api->get('/health/check', function () {
       return "hello, world";
    });

    $api->post('/sms', 'SmsLogController@sendSms');

    $api->group(['prefix' => 'file'], function ($api) {
        $api->post('/upload', 'FileController@upload');
        $api->delete('/del', 'FileController@del');
        $api->delete('/batchDel', 'FileController@batchDel');
    });
});

// 登录后才能使用的接口
$api->group(array_merge($params, $mwLogin), function ($api) {
});
