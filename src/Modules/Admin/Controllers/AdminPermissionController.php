<?php

namespace Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\AdminPermission;
use Modules\Common\Controllers\BaseController;
use Modules\Admin\Filters\AdminPermissionFilter;
use Modules\Admin\Requests\AdminPermissionRequest;
use Modules\Admin\Resources\AdminPermissionResource;

class AdminPermissionController extends BaseController
{
    public function store(AdminPermissionRequest $request, AdminPermission $model)
    {
        $inputs = $request->validated();
        $res = $model->create($inputs);

        return $this->created(AdminPermissionResource::make($res));
    }

    public function index(Request $request, AdminPermissionFilter $filter)
    {
        $perms = AdminPermission::query()
            ->filter($filter)
            ->orderByDesc('id');
        $perms = $request->get('all') ? $perms->get() : $perms->paginate();

        return $this->okObject(AdminPermissionResource::collection($perms));
    }

    public function edit(AdminPermission $adminPermission)
    {
        return $this->okObject(AdminPermissionResource::make($adminPermission));
    }

    public function update(AdminPermissionRequest $request, AdminPermission $adminPermission)
    {
        $inputs = $request->validated();
        $adminPermission->update($inputs);

        return $this->created(AdminPermissionResource::make($adminPermission));
    }

    public function destroy(AdminPermission $adminPermission)
    {
        $adminPermission->delete();

        return $this->noContent();
    }
}
