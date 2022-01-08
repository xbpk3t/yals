<?php

namespace Modules\Admin\Requests;

use Illuminate\Support\Arr;
use Modules\Admin\Utils\Admin;

class AdminUserProfileRequest extends AdminUserRequest
{
    public function rules()
    {
        $rules = Arr::only(parent::rules(), [
            'name', 'password', 'avatar',
        ]);

        return $rules;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Modules\Admin\Entities\AdminUser
     */
    public function userResource()
    {
        return Admin::user();
    }
}
