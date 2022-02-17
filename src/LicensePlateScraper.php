<?php
namespace Larangular\LPScraper;

use GuzzleHttp\Exception\RequestException;
use Larangular\Support\Instance;
use GuzzleHttp\Client as GuzzleClient;

class LicensePlateScraper {

    private $scrapers;
    private $client;

    public function __construct() {
        $this->scrapers = config('lp-scraper.scrapers');
        $this->client = new GuzzleClient(['timeout' => 30]);
    }

    public function getLicensePlateMetadata($licensePlate) {
        $response = false;
        foreach($this->scrapers as $scraper) {
            $response = $this->callScraper($scraper, ['license_plate' => $licensePlate]);
            if($response !== false) break;
        }
        return $response;
    }

    private function callScraper($scraperName, $options) {
        $response = false;
        $scraper = new $scraperName;

        if (Instance::instanceOf($scraper, Scraper::class)) {
            $request = null;
            try {
                $request = $scraper->getRequest($this->client, $options);
            } catch (RequestException $e) {
                //dd($e);
            } finally {
                if(!is_null($request)) {
                    $scraperWrapper = new ScraperWrapper($request);
                    if($scraperWrapper->isValid) {
                        $response = @$scraper->getScrapedValue($scraperWrapper);
                    }
                }
            }
        }

        return $response;
    }

}
