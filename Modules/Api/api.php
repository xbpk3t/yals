<?php

$api = app('Dingo\Api\Routing\Router');

$params = [
    'prefix' => 'api',
    'version' => 'v1.0',
    'namespace' => 'Modules\Api\Controllers',
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
    $api->group(['prefix' => '/user'], function ($api) {
        $api->post('/login', 'UserController@login');
    });
});

// 需要登录的接口
$api->group(array_merge($params, $mwLogin), function ($api) {
});
