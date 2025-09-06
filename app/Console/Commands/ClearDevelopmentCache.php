<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ClearDevelopmentCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears all cache and sessions for development environment.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Clearing all caches...');

        // Очистка всех кэшей Laravel
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        
        // Очистка кэша Filament и Livewire
        Artisan::call('filament:clear-cached-components');
        Artisan::call('filament:optimize-clear');

        // Очистка сессий (если используется драйвер 'database')
        $this->info('Clearing database sessions...');
        DB::table('sessions')->truncate();

        $this->info('All caches and sessions cleared successfully!');
        
        return 0;
    }
}
