<?php

$api = app('Dingo\Api\Routing\Router');

$params = [
    'prefix' => 'api',
    'version' => 'v1.0',
    'namespace' => 'Modules\Admin\Controllers',
    'limit' => config('api.rate_limits.sign.limit'),
    'expires' => config('api.rate_limits.sign.expires'),
];
$middleware1 = ['middleware' => ['api.throttle', 'cors']];
$middleware2 = ['middleware' => [
    'api.throttle',
    'cors',
    'jwt.auth',
]];

// 不需要登录的接口
$api->group(array_merge($params, $middleware1), function ($api) {
    $api->group(['prefix' => '/user'], function ($api) {
        // 后台登录
        $api->post('/log', 'AdminController@login')->name('login');
    });
});

// 需要登录的接口
$api->group(array_merge($params, $middleware2), function ($api) {

    $api->resource('admin-permissions', 'AdminPermissionController');
    $api->resource('admin-roles', 'AdminRoleController');

    // 用户展示，编辑的展示，编辑动作
    $api->get('user', 'AdminUserController@user')->name('user');
    $api->get('user/edit', 'AdminUserController@editUser')->name('user.edit');
    $api->put('user', 'AdminUserController@updateUser')->name('user.update');

    $api->resource('admin-users', 'AdminUserController');
});
