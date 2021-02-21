<?php

namespace Modules\Admin\Entities;

/**
 * Class AdminRole
 * @package Modules\Admin\Entities
 *
 * @property string $name
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 */
class AdminRole extends Model
{
    protected $table = 'admin_role';

    protected $fillable = ['name', 'slug'];

    public function permissions()
    {
        return $this->belongsToMany(
            AdminPermission::class,
            'admin_role_permission',
            'role_id',
            'permission_id'
        );
    }

    public function delete()
    {
        $this->permissions()->detach();

        return parent::delete();
    }
}
