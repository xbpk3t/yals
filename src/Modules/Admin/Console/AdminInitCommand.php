<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\AdminRole;
use Modules\Admin\Entities\AdminUser;
use Modules\Admin\Entities\AdminPermission;

class AdminInitCommand extends Command
{
    public static $initConfirmTip = '初始化操作，会清空路由、管理员、角色和权限表，以及相关关联表数据。是否确认？';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:init';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化基础路由配置，超级管理员角色和权限';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm(static::$initConfirmTip)) {
            $this->createUserRolePermission();
            $this->info('初始化完成，管理员为：admin，密码为：000000');

            return 1;
        }

        return 0;
    }

    protected function createUserRolePermission()
    {
        AdminUser::truncate();
        AdminRole::truncate();
        AdminPermission::truncate();

        collect(['admin_role_permission', 'admin_user_permission', 'admin_user_role', 'vue_router_role'])
            ->each(function ($table) {
                DB::table($table)->truncate();
            });

        $user = AdminUser::create([
            'name' => '管理员',
            'username' => 'admin',
            'password' => bcrypt('000000'),
        ]);

        $user->roles()->create([
            'name' => '超级管理员',
            'slug' => 'administrator',
        ]);

        AdminRole::first()
            ->permissions()
            ->create([
                'name' => '所有权限',
                'slug' => 'pass-all',
                'http_path' => '*',
            ]);
    }

    /**
     * 组合字段和对应的值
     *
     * @param array $fields  字段
     * @param array $inserts 值，不带字段的
     * @param array $extra   每列都相同的数据，带字段
     */
    protected function combineInserts(array $fields, array $inserts, array $extra): array
    {
        return array_map(function ($i) use ($fields, $extra) {
            $i = array_combine($fields, $i);

            return array_merge($i, $extra);
        }, $inserts);
    }
}
