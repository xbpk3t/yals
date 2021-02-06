<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Api\Entities\User;
use Modules\Api\Http\Requests\User\LoginRequest;
use Modules\Common\Http\Controllers\BaseController;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    protected $user;

    public function __construct(User  $user) {
        $this->user = $user;
    }

    public function login(LoginRequest $request)
    {
        $res = [
            'token' => JWTAuth::fromUser($this->user)
        ];
        return $this->respondSuccess($res);
    }


    public function refreshToken()
    {
        return $this->respondSuccess();
    }
}
