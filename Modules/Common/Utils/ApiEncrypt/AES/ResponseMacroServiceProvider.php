<?php

namespace Modules\Common\Utils\ApiEncrypt\AES;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Encryption\Encrypter;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('encrypt', function ($value) {
            if (is_array($value)) {
                $value = jsonEncode($value);
            }
            if ($value instanceof Jsonable) {
                $value = $value->toJson();
            }

            return Response::make(app()->make(Encrypter::class)
                ->encrypt((string) $value, false));
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
