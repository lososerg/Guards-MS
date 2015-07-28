<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\Inspire',
        'App\Console\Commands\StatsCommand',
        'App\Console\Commands\TestCommand',
        'App\Console\Commands\TelegramCommand',
        'App\Console\Commands\AnekdotCommand',
        'App\Console\Commands\SendAnekdotesCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('stats:collect')
            ->dailyAt('22:00');
        //$schedule->command('telegram:update')->everyFiveMinutes();
        //$schedule->command('telegram:update')->cron('* * * * *');
        $schedule->command('anekdot')->cron('* * * * *');
        $schedule->command('anekdot:send')->dailyAt('07:00');
    }

}
