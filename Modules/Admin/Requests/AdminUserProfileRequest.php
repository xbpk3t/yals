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

    public function userResource()
    {
        return Admin::user();
    }
}
