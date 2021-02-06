<?php

$api = app('Dingo\Api\Routing\Router');

$params = [
    'prefix' => 'base',
    'version' => 'v1.0',
    'namespace' => 'Modules\Base\Http\Controllers',
];

$api->group($params, function ($api) {
    // 不需要登录的接口
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        $api->post('/sendSms', 'SmsLogController@send');
    });

    // 登录后才能使用的接口
    $api->group([
        // jwt中间件
        'middleware' => ['api.throttle', 'jwt.auth'],
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {


    });


});
