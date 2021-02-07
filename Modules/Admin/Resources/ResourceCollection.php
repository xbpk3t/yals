<?php

namespace Modules\Admin\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResourceCollection extends AnonymousResourceCollection
{
    public static $wrap = null;

    public function withResponse($request, $response)
    {
        $data = $response->getData(true);
        unset($data['links'], $data['meta']['path']);

        $response->setData($data);
    }
}
