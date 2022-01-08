<?php

namespace Modules\Api\Controllers;

use Cache;
use Exception;
use Illuminate\Support\Str;
use Modules\Api\Entities\User;
use Tymon\JWTAuth\JWTAuth as JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Modules\Api\Requests\User\LoginRequest;
use Modules\Api\Requests\User\RegisterRequest;
use Modules\Common\Controllers\BaseController;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserController extends BaseController
{
    protected $user;
    protected $jwt;

    public function __construct(User $user, JWT $jwt)
    {
        $this->user = $user;
        $this->jwt = $jwt;
    }

    /**
     * 用户注册.
     */
    public function register(RegisterRequest $request): object
    {
        $code = $request->code;
        $mobile = $request->mobile;
        $password = $request->password;

        if (!$code == env('COMMON_CODE') && !$code == Cache::get($mobile)) {
            return $this->okMsg('短信验证码错误');
        }

        try {
            $user = $this->user->create(['mobile' => $request->mobile, 'username' => Str::uuid(), 'password' => Hash::make($password)]);

            $token = JWTAuth::fromUser($user);

            return $this->okList(compact('token'));
        } catch (Exception $e) {
            return $this->okMsg($e->getMessage());
        }
    }

    public function login(LoginRequest $request): object
    {
        try {
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

        $token = JWTAuth::fromUser($this->user);

        return $this->okList(compact('token'));
    }

    /**
     * 刷新token.
     */
    public function refresh(): object
    {
        $token = $this->jwt->getToken();

        if (!$token) {
            throw new UnauthorizedHttpException('Token not provided');
        }

        try {
            $token = $this->jwt->refresh();
        } catch (TokenInvalidException $exception) {
            return $this->okMsg($exception->getMessage());
        }

        return $this->okList(compact('token'));
    }

    /**
     * 退出登录.
     *
     * @throws JWTException
     */
    public function logout(): object
    {
        if ($this->jwt->parseToken()->invalidate()) {
            return $this->okMsg('退出成功');
        }

        $token = $this->jwt->getToken();
        $this->jwt->invalidate($token);

        return $this->okMsg('退出成功');
    }
}
