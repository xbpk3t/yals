<?php

namespace Modules\Common\Console;

use Illuminate\Console\Command;

class MigrationGenerateCommand extends Command
{
    protected $signature = '';

    protected $description = '';

    protected $clearDays = '15';

    protected $tableMap = [
        'admin_menu',
        'admin_permission',
        'admin_role',
        'admin_role_menu',
        'admin_role_permission',
        'admin_user',
        'admin_user_permission',
        'admin_user_role',
    ];

    public function handle()
    {
        $this->createMigrations();

        $this->seeds();

        $this->clearHistoryMigrations();
    }

    protected function createMigrations()
    {
    }

    protected function seeds()
    {
        $tableName = 'admin_role';
    }

    protected function clearHistoryMigrations()
    {
    }
}
