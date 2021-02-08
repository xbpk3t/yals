<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Utils\Admin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Exceptions\VueRouterException;

class VueRouter extends Model
{
    use ModelTree {
        ModelTree::allNodesQuery as parentAllNodesQuery;
    }
    protected $casts = [
        'parent_id' => 'integer',
        'order' => 'integer',
        'cache' => 'bool',
        'menu' => 'bool',
    ];
    protected $fillable = [
        'parent_id',
        'order',
        'title',
        'icon',
        'path',
        'cache',
        'menu',
        'permission',
    ];
    protected $treeWithAuth = false;

    /**
     * parent_id 默认为 0 处理.
     *
     * @param $value
     */
    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = $value ?: 0;
    }

    public function roles()
    {
        return $this->belongsToMany(
            AdminRole::class,
            'vue_router_role',
            'vue_router_id',
            'role_id'
        );
    }

    public function treeWithAuth()
    {
        $this->treeWithAuth = true;

        return $this;
    }

    public function replaceFromFile(UploadedFile $file): array
    {
        $tree = json_decode(file_get_contents($file->getRealPath()), true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new VueRouterException(sprintf('JSON 数据解析错误 [ %s ]', json_last_error()));
        }

        $flatten = $this->flatten($tree);

        DB::beginTransaction();
        $this->truncate();
        $this->insert($flatten);
        DB::commit();

        return $tree;
    }

    public function allNodesQuery(): Builder
    {
        return $this->parentAllNodesQuery()
            ->when($this->treeWithAuth, function (Builder $query) {
                $query->with('roles');
            });
    }

    protected function ignoreTreeNode($node): bool
    {
        // 不需要鉴权，或者有权限，则不忽略
        if (
            // 不需要鉴权
            !$this->treeWithAuth ||
            // 角色可见
            (Admin::user()->visible($node['roles']) &&
                // 并且路由没有配置权限，或者配置了权限，用户也有权限
                (empty($node['permission']) ?: Admin::user()->can($node['permission'])))
        ) {
            return false;
        }

        return true;
    }
}
