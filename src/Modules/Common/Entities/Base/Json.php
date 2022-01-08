<?php

namespace Modules\Common\Entities\Base;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Json implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return jsonDecode($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return jsonEncode($value);
    }
}
