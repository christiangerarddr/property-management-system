<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all log files in the logs directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logsDir = storage_path('logs');

        if (is_dir($logsDir)) {
            $files = scandir($logsDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'log') {
                    file_put_contents("$logsDir/$file", ''); // Clear file content
                }
            }
            $this->info('All log files have been cleared.');
        } else {
            $this->error("Directory $logsDir does not exist.");
        }
    }
}
