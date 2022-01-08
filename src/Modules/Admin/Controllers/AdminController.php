<?php

namespace Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Utils\Admin;
use Modules\Admin\Resources\AdminUserResource;
use Modules\Common\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Admin\Requests\AdminUserProfileRequest;

class AdminController extends BaseController
{
    use AuthenticatesUsers;

    public function logout()
    {
        $this->guard()->logout();

        return $this->noContent();
    }

    // 修改用户名、密码、头像
    public function updateUser(AdminUserProfileRequest $request)
    {
        $inputs = $request->validated();
        Admin::user()->updateUser($inputs);

        return $this->callAction('user', [])->setStatusCode(201);
    }

    // 当前用户及对应角色、权限
    public function currentUser()
    {
        $user = Admin::user();
        $user->load(['roles', 'permissions']);

        return $this->okObject(AdminUserResource::make($user));
    }

    // 当前用户及对应角色、权限
    public function user()
    {
        $user = Admin::user();

        return $this->okObject(
            AdminUserResource::make($user)
                ->gatherAllPermissions()
                ->onlyRolePermissionSlugs()
        );
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
