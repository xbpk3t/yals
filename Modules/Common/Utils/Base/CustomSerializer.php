<?php

namespace Modules\Common\Utils\Base;

use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\DataArraySerializer;

class CustomSerializer extends DataArraySerializer
{
    /**
     * @param string $resourceKey
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return [
            'code' => 200,
            'message' => 'success',
            'data' => $data,
        ];
    }

    /**
     * @param string $resourceKey
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return [
            'code' => 200,
            'message' => 'success',
            'data' => $data,
        ];
    }

    public function paginator(PaginatorInterface $paginator)
    {
        return parent::paginator($paginator);
    }
}
