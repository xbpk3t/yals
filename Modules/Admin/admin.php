<?php

$api = app('Dingo\Api\Routing\Router');

$params = [
    'prefix' => 'api',
    'version' => 'v1.0',
    'namespace' => 'Modules\Admin\Controllers',
    'middleware' => ['api.throttle', 'cors'],
    'limit' => config('api.rate_limits.sign.limit'),
    'expires' => config('api.rate_limits.sign.expires'),
];

// 不需要登录的接口
$api->group($params, function ($api) {
    $api->group(['prefix' => '/user'], function ($api) {
        // 后台登录
        $api->post('/log', 'AdminController@login');
    });
});

// 需要登录的接口
$api->group($params, function ($api) {
});
