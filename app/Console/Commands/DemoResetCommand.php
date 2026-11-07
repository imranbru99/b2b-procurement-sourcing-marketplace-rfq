<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoResetCommand extends Command
{
    protected $signature = 'demo:reset {--force : Force the operation to run when in production}';

    protected $description = 'Reset the demo database (migrate:fresh --seed)';

    public function handle(): int
    {
        if (! config('marketplace.demo')) {
            $this->error('APP_DEMO is not enabled. Refusing to reset the database.');

            return self::FAILURE;
        }

        $this->warn('Running migrate:fresh --seed for demo environment...');

        $this->call('migrate:fresh', [
            '--seed' => true,
            '--force' => $this->option('force') || app()->environment('local', 'testing', 'staging'),
        ]);

        $this->info('Demo database reset complete.');

        return self::SUCCESS;
    }
}
