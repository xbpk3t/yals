<?php

namespace Modules\Common\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;

class InitCommand extends Command
{
    protected $signature = 'app:init';

    protected $description = '初始化项目';

    protected $envMap = [
        'DB_HOST',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD',
    ];

    public function handle()
    {
        // todo composer install?
        try {
            if (-1 != version_compare(phpversion(), '7.4')) {
                $this->success('基础环境检测通过');
            }
        } catch (Exception $exception) {
            throw new Exception('版本较低，请升级php版本');
        }

        try {
            $currentEnv = trim('.env.' . File::get('.env'));
            $isExist = File::exists($currentEnv);
            if (!$isExist) {
                copy('.env.prod', $currentEnv);
            }

            $this->success('配置文件生成成功');
        } catch (Exception $exception) {
            throw new Exception('配置文件错误');
        }

        try {
            if (false == $this->checkEnv()) {
                $this->errAndExit('MySQL未配置，请先手动配置');
            }
            // 判断数据库是否已经存在
            if (!DB::connection()->getDatabaseName()) {
                $this->errAndExit('数据库连接错误，请确定后重试');
            }
            $this->success('数据库检测通过');
        } catch (Exception $exception) {
            throw new Exception('数据库配置错误');
        }

        if (Artisan::call('migrate') instanceof QueryException) {
            $this->errAndExit('migrate数据失败');
        }
        if (Artisan::call('db:seed')) {
            $this->errAndExit('seed数据失败');
        }

        $this->success('表数据配置成功');
    }

    private function checkEnv(): bool
    {
        foreach ($this->envMap as $env) {
            if (null === env($env)) {
                return false;
            }
        }

        return true;
    }

    private function errAndExit(string $msg)
    {
        $this->error($msg);
        exit();
    }

    private function success(string $msg)
    {
        $this->info(">>>$msg.🎉");
    }
}
