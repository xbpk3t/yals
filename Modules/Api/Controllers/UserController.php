<?php

namespace Modules\Api\Controllers;

use Exception;
use Modules\Api\Entities\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Modules\Api\Requests\User\LoginRequest;
use Modules\Api\Requests\User\RegisterRequest;
use Modules\Common\Controllers\BaseController;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends BaseController
{
    protected $user;
    protected $jwt;

    public function __construct(User $user, JWTAuth $jwt)
    {
        $this->user = $user;
        $this->jwt = $jwt;
    }

    public function register(RegisterRequest $request): object
    {
        return $this->okMsg();
    }

    public function login(LoginRequest $request): object
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
        } catch (TokenExpiredException $e) {
            return $this->okMsg('登录过期');
        } catch (TokenInvalidException $e) {
            return $this->okMsg('无效的token');
        } catch (JWTException $e) {
            return $this->okMsg('token未提交');
        } catch (Exception $e) {
            return $this->okMsg('操作出错');
        }

        $res = [
            'token' => JWTAuth::fromUser($this->user),
        ];

        return $this->okList($res);
    }
}
