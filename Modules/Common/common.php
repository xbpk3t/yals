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
    $api->post('/sms', 'SmsLogController@sendSms');
    $api->post('/upload', 'UploadFileController@upload');
});

// 登录后才能使用的接口
$api->group(array_merge($params, $mwLogin), function ($api) {
});
