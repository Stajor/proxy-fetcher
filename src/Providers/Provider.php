<?php namespace ProxyFetcher\Providers;

use DOMDocument;
use DOMXPath;
use Faker\Factory;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class Provider {
    protected function request(string $url): ResponseInterface {
        $faker      = Factory::create();
        $client     = new Client();
        $response   = $client->request('GET', $url, ['headers' => [
            'User-Agent' => $faker->userAgent
        ]]);

        return $response;
    }

    protected function requestXpath(string $url): DOMXPath {
        $doc = new DOMDocument();

        libxml_use_internal_errors(true);

        $doc->loadHTML($this->request($url)->getBody());

        return new DOMXPath($doc);
    }
}
