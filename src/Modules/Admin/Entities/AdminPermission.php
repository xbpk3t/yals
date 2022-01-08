<?php

namespace Modules\Admin\Entities;

/**
 * Class AdminPermission.
 *
 * @property string $name
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 */
class AdminPermission extends Model
{
    public static $httpMethods = [
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS', 'HEAD',
    ];
    protected $table = 'admin_permission';
    protected $fillable = ['name', 'slug', 'http_method', 'http_path'];

    public function setHttpMethodAttribute($method)
    {
        if (is_array($method)) {
            $this->attributes['http_method'] = implode(',', $method) ?: null;
        } else {
            $this->attributes['http_method'] = $method;
        }
    }

    public function getHttpMethodAttribute($method)
    {
        return array_filter(explode(',', $method));
    }

    public function setHttpPathAttribute($httpPath)
    {
        if (is_array($httpPath)) {
            $this->attributes['http_path'] = implode("\n", $httpPath) ?: null;
        } else {
            $this->attributes['http_path'] = $httpPath;
        }
    }

    public function getHttpPathAttribute($httpPath)
    {
        return array_filter(explode("\n", $httpPath));
    }

    public function roles()
    {
        return $this->belongsToMany(
            AdminRole::class,
            'admin_role_permission',
            'role_id',
            'permission_id'
        );
    }
}
