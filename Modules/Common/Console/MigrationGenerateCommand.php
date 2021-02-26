<?php

namespace Modules\Common\Console;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Orangehill\Iseed\TableNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MigrationGenerateCommand extends Command
{
    // Migrate And Seed
    protected $signature = 'app:mas';

    protected $description = '';

    protected $clearDays = '5';

    protected $tableMap = [
        'admin_menu',
        'admin_permission',
        'admin_role',
        'admin_role_menu',
        'admin_role_permission',
        'admin_user',
        'admin_user_permission',
        'admin_user_role',
        'tz_user',
    ];

    public function handle()
    {
        if (true == $this->createMigrations()) {
            $this->clearHistoryMigrations();
        }

        $this->seeds();
    }

    /**
     * @return bool
     */
    protected function createMigrations()
    {
        try {
            Artisan::call('migrate:generate', [
                '--no-interaction' => true,
            ]);
            $this->info('create migrations success');

            return true;
        } catch (Exception $exception) {
            $this->error('create migrations error');
//            return $exception->getMessage();
            return false;
        }
    }

    /**
     * @return bool
     */
    protected function seeds()
    {
        try {
            Artisan::call('iseed', [
                'tables' => implode(',', $this->tableMap),
                '--force' => true,
            ]);
            $this->info('create table seeders success');

            return true;
        } catch (TableNotFoundException $exception) {
            // todo 加一个crontab的log-channel
            $this->error('create table seeders error');
//            return $exception->getMessage();
            return false;
        }
    }

    protected function clearHistoryMigrations()
    {
        $dbPath = database_path('migrations');
        if (!File::exists($dbPath)) {
            $this->error('database文件夹不存在');
        }

        try {
            $d = File::files($dbPath);

            // 根据日期去删除文件，批量移除
            $days = beforeDaysFormatList($this->clearDays, 'Y_m_d');
            foreach (array_diff($days, [todayDate('Y_m_d')]) as $day) {
                foreach ($d as $k) {
                    if (Str::startsWith($k->getRelativePathname(), $day)) {
                        File::delete($k->getPathname());
                    }
                }
            }
            $this->info('migration files delete success');

            return true;
        } catch (FileException $exception) {
            throw new FileException('migration files delete error');
        }
    }
}
