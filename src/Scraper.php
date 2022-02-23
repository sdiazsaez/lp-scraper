<?php

namespace Larangular\LPScraper;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class Scraper {

    abstract public function getRequest(Client $client, array $options): ResponseInterface;

    abstract public function getScrapedValue(ScraperWrapper $wrapper, string $licensePlate): ?array;
}
