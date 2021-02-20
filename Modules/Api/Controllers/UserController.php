<?php

namespace Modules\Api\Controllers;

use Modules\Api\Entities\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\Api\Requests\User\LoginRequest;
use Modules\Common\Controllers\BaseController;

class UserController extends BaseController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(LoginRequest $request)
    {
        try {
            //验证用户是否存在，
            if (empty($this->user->where('username', $request['username'])->first())) {
                return $this->okMsg('手机号未注册');
            }
            //用户与密码是否正确
            if (!$token = $this->jwt->attempt($request->only('username', 'password'))) {
                return $this->okMsg('用户名或密码错误');
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->okMsg('登录过期');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->okMsg('无效的token');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->okMsg('token未提交');
        } catch (\Exception $e) {
            return $this->okMsg('操作出错');
        }

        $res = [
            'token' => JWTAuth::fromUser($this->user),
        ];

        return $this->okList($res);
    }
}
