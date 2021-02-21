<?php

namespace Modules\Admin\Resources;

use Modules\Admin\Entities\AdminRole;

/**
 * Class AdminRoleResource.
 *
 * @property string $name
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 */
class AdminRoleResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var AdminRole $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'slug' => $model->slug,
            'permissions' => AdminPermissionResource::collection($this->whenLoaded('permissions')),
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->updated_at,
        ];
    }
}
