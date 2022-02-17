<?php

namespace Larangular\LPScraper\Tests;

use Larangular\LPScraper\LicensePlateScraper;

class SourceTest extends TestCase {

    public function testGetLicensePlateMetadata(): void {
        $lp = new LicensePlateScraper();
        $value = $lp->getLicensePlateMetadata('HCZJ85');

        $this->assertIsArray($value);
        $this->assertCount(10, $value);
        $this->assertEquals([
            'national_id',
            'name',
            'license_plate',
            'type',
            'make',
            'model',
            'year',
            'color',
            'engine_number',
            'chassis',
        ], array_keys($value));
    }
}
