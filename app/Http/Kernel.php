<?php

namespace App\Http;

use Fruitcake\Cors\HandleCors;
use Modules\Admin\Middleware\LogOperation;
use Modules\Common\Utils\ApiEncrypt\AES\AesDecryptMiddleware;
use Modules\Common\Utils\ApiEncrypt\AES\AesEncryptMiddleware;
use Modules\Common\Utils\Signature\Middleware\SignatureMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Fruitcake\Cors\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
//        LogOperation::class,
//        AesEncryptMiddleware::class


//        \App\Http\Middleware\TrustHosts::class,
//        \Modules\Admin\Http\Middleware\TrustProxies::class,
//        \Modules\Admin\Http\Middleware\PreventRequestsDuringMaintenance::class,
//        \Modules\Admin\Http\Middleware\TrimStrings::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,


//            \Modules\Admin\Http\Middleware\EncryptCookies::class,
//            \Illuminate\Session\Middleware\AuthenticateSession::class,
//            \Modules\Admin\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'cors' => HandleCors::class,
        'api.signature' => SignatureMiddleware::class,
        'aes.decrypt' => AesDecryptMiddleware::class,
        'aes.encrypt' => AesEncryptMiddleware::class,
        'admin.log' => LogOperation::class


//        'auth' => \Modules\Admin\Http\Middleware\Authenticate::class,
//        'guest' => \Modules\Admin\Http\Middleware\RedirectIfAuthenticated::class,
    ];

    protected $middlewarePriority = [
        // 请求进来，先解密再加密
        AesDecryptMiddleware::class,
        AesEncryptMiddleware::class
    ];
}
