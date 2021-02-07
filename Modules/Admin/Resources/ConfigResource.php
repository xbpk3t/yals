<?php

namespace Modules\Admin\Resources;

use Modules\Admin\Entities\Config;

class ConfigResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Config $model */
        $model = $this->resource;

        $data = [
            'type_text' => $model->type_text,
            'category' => ConfigCategoryResource::make($this->whenLoaded('category')),
        ];

        return array_merge(parent::toArray($request), $data);
    }
}
