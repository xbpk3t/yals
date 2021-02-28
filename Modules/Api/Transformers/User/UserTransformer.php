<?php

namespace Modules\Api\Transformers\User;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform($user)
    {
        return [
            'username' => $user->username,
            'mobile' => $user->mobile,
        ];
    }
}
