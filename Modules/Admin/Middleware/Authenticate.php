<?php

namespace Modules\Admin\Middleware;

use Modules\Admin\Utils\Admin;
use Modules\Admin\Traits\UrlWhitelist;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use UrlWhitelist;
    protected $urlWhitelist = [
        '/configs/system_basic/values',
    ];

    public function handle($request, \Closure $next, ...$guards)
    {
        if ($this->shouldPassThrough($request)) {
            return $next($request);
        }

        return parent::handle(...func_get_args());
    }

    protected function urlWhitelist(): array
    {
        return array_map(function ($url) {
            return Admin::url($url);
        }, $this->urlWhitelist);
    }

    /**
     * {@inheritdoc}
     */
    protected function authenticate($request, array $guards)
    {
        parent::authenticate($request, ['admin']);
    }
}
