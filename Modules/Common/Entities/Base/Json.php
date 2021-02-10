<?php


namespace Modules\Common\Entities\Base;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Json implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        // TODO: Implement get() method.
        return json_decode($value, true);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        // TODO: Implement set() method.
        return json_encode($value);
    }
}
