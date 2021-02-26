<?php


namespace Modules\Common\Console;


use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitCommand extends Command
{

    protected $signature = 'app:init';

    protected $description = '初始化项目';

    protected $envMap = [
        'DB_HOST',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD'
    ];

    public function handle()
    {
        // todo composer install?
        try {
            if (version_compare(phpversion(), '7.4') == -1) {
                $this->error("版本较低，请升级php版本");
            }
            $this->info(">>>基础环境检测通过");

            if (!copy(".env.prod", ".env.his")) {
                $this->error("配置文件错误");
            }
            $this->info(">>>配置文件生成成功");

            if ($this->checkEnv() == false) {
                $this->error("MySQL未配置");
            }
            // 判断数据库是否已经存在
            if (!DB::connection()->getDatabaseName()) {
                $this->error("数据库连接错误，请确定后重试");
            }
            $this->info(">>>数据库检测通过");

            if (Artisan::call('migrate') instanceof QueryException) {
                $this->error("生成表接口错误");
            }
            $this->info(">>>表接口migrate成功");

            Artisan::call('db:seed');
        } catch (Exception $exception) {
            throw new Exception('项目初始化失败');
        }
    }

    private function checkEnv(): bool
    {
        foreach ($this->envMap as $env) {
            if (is_null(env($env))) {
                return false;
            }
        }

        return true;
    }
}
