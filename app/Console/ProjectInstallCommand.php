<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectInstallCommand extends Command
{
    protected $signature = 'project-install';

    protected $description = 'Project install';

    public function handle()
    {
        Artisan::call('key:generate');
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
}
