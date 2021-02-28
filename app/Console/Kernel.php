<?php

namespace App\Console;

use Modules\Common\Console\InitCommand;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Admin\Console\AdminInitCommand;
use Modules\Common\Console\MigrationGenerateCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AdminInitCommand::class,
        MigrationGenerateCommand::class,
        InitCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command(MigrationGenerateCommand::class)->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
