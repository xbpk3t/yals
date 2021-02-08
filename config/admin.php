<?php

return [
    'bootstrap' => app_path('Admin/bootstrap.php'),
    'route' => [

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],
    ],
    'directory' => app_path('Admin'),
    'title' => 'Admin',
    'https' => env('ADMIN_HTTPS', false),
//    'auth' => [
//
//        'controller' => App\Admin\Controllers\AuthController::class,
//
//        'guard' => 'admin',
//
//        'guards' => [
//            'admin' => [
//                'driver'   => 'session',
//                'provider' => 'admin',
//            ],
//        ],
//
//        'providers' => [
//            'admin' => [
//                'driver' => 'eloquent',
//                'model'  => Encore\Admin\Auth\Database\Administrator::class,
//            ],
//        ],
//
//        // Add "remember me" to login form
//        'remember' => true,
//
//        // Redirect to the specified URI when user is not authorized.
//        'redirect_to' => 'auth/login',
//
//        // The URIs that should be excluded from authorization.
//        'excepts' => [
//            'auth/login',
//            'auth/logout',
//        ],
//    ],


//    'upload' => [
//        // Disk in `config/filesystem.php`.
//        'disk' => 'admin',
//        // Image and file upload path under the disk above.
//        'directory' => [
//            'image' => 'images',
//            'file'  => 'files',
//        ],
//    ],

//    'database' => [
//        // Database connection for following tables.
//        'connection' => '',
//
//        // User tables and model.
//        'users_table' => 'admin_users',
//        'users_model' => Encore\Admin\Auth\Database\Administrator::class,
//
//        // Role table and model.
//        'roles_table' => 'admin_roles',
//        'roles_model' => Encore\Admin\Auth\Database\Role::class,
//
//        // Permission table and model.
//        'permissions_table' => 'admin_permissions',
//        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,
//
//        // Menu table and model.
//        'menu_table' => 'admin_menu',
//        'menu_model' => Encore\Admin\Auth\Database\Menu::class,
//
//        // Pivot table for table above.
//        'operation_log_table'    => 'admin_operation_log',
//        'user_permissions_table' => 'admin_user_permissions',
//        'role_users_table'       => 'admin_role_users',
//        'role_permissions_table' => 'admin_role_permissions',
//        'role_menu_table'        => 'admin_role_menu',
//    ],

    'operation_log' => [
        'enable' => true,
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],
        'except' => [
            'admin/auth/logs*',
        ],
    ],
    'check_route_permission' => true,
    'check_menu_roles'       => true,
    'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',
    'layout' => ['sidebar-mini', 'sidebar-collapse'],
    'login_background_image' => '',
    'show_version' => true,
    'show_environment' => true,
    'menu_bind_permission' => true,
    'enable_default_breadcrumb' => true,
];
