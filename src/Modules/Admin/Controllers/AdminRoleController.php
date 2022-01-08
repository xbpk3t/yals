<?php

namespace Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\AdminRole;
use Modules\Admin\Filters\AdminRoleFilter;
use Modules\Admin\Entities\AdminPermission;
use Modules\Admin\Requests\AdminRoleRequest;
use Modules\Admin\Resources\AdminRoleResource;
use Modules\Common\Controllers\BaseController;

class AdminRoleController extends BaseController
{
    // 写入
    public function store(AdminRoleRequest $request, AdminRole $model)
    {
        $inputs = $request->validated();
        $role = $model->create($inputs);

        if (!empty($perms = $inputs['permissions'] ?? [])) {
            $role->permissions()->attach($perms);
        }

        return $this->created(AdminRoleResource::make($role));
    }

    // 编辑
    public function edit(Request $request, AdminRole $adminRole)
    {
        $adminRole->load(['permissions']);
        $roleData = AdminRoleResource::make($adminRole)->toArray($request);

        return $this->okList([
            'role' => $roleData,
            'permissions' => $this->formData()['permissions'],
        ]);
    }

    // 修改
    public function update(AdminRoleRequest $request, AdminRole $adminRole)
    {
        $inputs = $request->validated();
        $adminRole->update($inputs);
        if (isset($inputs['permissions'])) {
            $adminRole->permissions()->sync($inputs['permissions']);
        }

        return $this->created(AdminRoleResource::make($adminRole));
    }

    // 删除
    public function destroy(AdminRole $adminRole)
    {
        $adminRole->delete();

        return $this->noContent();
    }

    // 展示
    public function index(Request $request, AdminRoleFilter $filter)
    {
        $roles = AdminRole::query()
            ->with(['permissions'])
            ->filter($filter)
            ->orderByDesc('id');
        $roles = $request->get('all') ? $roles->get() : $roles->paginate();

        return $this->okObject(AdminRoleResource::collection($roles));
    }

    // 添加
    public function create()
    {
        return $this->okList($this->formData());
    }

    /**
     * 返回添加和编辑表单所需的选项数据.
     *
     * @return array
     */
    protected function formData()
    {
        $permissions = AdminPermission::query()
            ->orderByDesc('id')
            ->get();

        return compact('permissions');
    }
}
