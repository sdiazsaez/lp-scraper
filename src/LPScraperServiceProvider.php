<?php

namespace Larangular\LPScraper;

use Illuminate\Support\ServiceProvider;

class LPScraperServiceProvider extends ServiceProvider {

    public function boot(): void {
        $this->publishes([
            __DIR__ . '/../config/lp-scraper.php' => config_path('lp-scraper.php'),
        ]);
    }

    public function register(): void {
        $this->app->register('Larangular\Support\SupportServiceProvider');
        $this->mergeConfigFrom(__DIR__ . '/../config/lp-scraper.php', 'lp-scraper');
    }
}
