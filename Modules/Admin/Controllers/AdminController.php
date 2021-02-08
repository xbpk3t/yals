<?php

namespace Modules\Admin\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Admin\Utils\Admin;
use Modules\Common\Controllers\BaseController;
use Illuminate\Http\Request;


class AdminController extends BaseController
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'username';
    }

    public function logout()
    {
        $this->guard()->logout();

        return $this->noContent();
    }

    protected function sendLoginResponse(Request $request)
    {
        $res = [
            'token' => $this->guard()->getToken()->get(),
            'token_type' => 'bearer',
            'expired_in' => $this->guard()->factory()->getTTL() * 60,
        ];

        return $this->okList($res);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt($this->credentials($request));
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Tymon\JWTAuth\JWTGuard|\Tymon\JWTAuth\JWT
     */
    protected function guard()
    {
        return Admin::guard();
    }
}
