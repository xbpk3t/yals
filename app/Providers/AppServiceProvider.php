<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Common\Utils\Base\CustomSerializer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->fractal();
    }

    private function fractal()
    {
        app('Dingo\Api\Transformer\Factory')->setAdapter(function ($app) {
            $fractal = new \League\Fractal\Manager();
            $fractal->setSerializer(new CustomSerializer());

            return new \Dingo\Api\Transformer\Adapter\Fractal($fractal, 'include', ',');
        });
    }
}
