<?php

namespace Larangular\LPScraper\PatenteChile;

use GuzzleHttp\Client;
use Larangular\LPScraper\Scraper;
use Larangular\LPScraper\ScraperWrapper;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class PatenteChileScraper extends Scraper {

    public function getScrapedValue(ScraperWrapper $wrapper): ?array {
        $data = [];
        $wrapper->getContent()
                ->filter('#tblDataVehicle tr')
                ->each(function (Crawler $node, $i) use (&$data) {
                    $tds = $node->children();
                    if ($tds->count() != 2) {
                        return;
                    }

                    $key = strtolower(str_replace(['N° ', 'ñ'], '', $tds->first()->innerText()));
                    $data[$key] = $tds->last()->text();
                });

        return [
            'national_id'   => @$data['rut'],
            'name'          => @$data['nombre'],
            'license_plate' => @$data['patente'],
            'type'          => @$data['tipo'],
            'make'          => @$data['marca'],
            'model'         => @$data['modelo'],
            'year'          => @$data['ao'],
            'color'         => @$data['color'],
            'engine_number' => @$data['motor'],
            'chassis'       => @$data['chasis'],
        ];
    }

    public function getRequest(Client $client, array $options): ResponseInterface {
        return $client->request('POST', 'https://www.patentechile.com/resultados', [
            'headers'     => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent'   => 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0',
                'Accept'       => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            ],
            'form_params' => [
                'frmTerm'   => $options['license_plate'],
                'frmOpcion' => 'vehiculo',
            ],
        ]);
    }
}
