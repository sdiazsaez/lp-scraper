<?php

namespace Larangular\LPScraper\Tests;

use Larangular\LPScraper\LPScraperServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase {

    protected function getEnvironmentSetUp($app) {
        $app['config']->set('lp-scraper', require(__DIR__ . '/../config/lp-scraper.php'));
    }

    protected function getPackageProviders($app): array {
        return [
            LPScraperServiceProvider::class,
        ];
    }

}
