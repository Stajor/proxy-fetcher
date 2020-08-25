<?php namespace ProxyFetcher\Providers;

use DOMDocument;
use DOMXPath;
use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class Provider {
    /**
     * @param string $url
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function request(string $url): ResponseInterface {
        $faker  = Factory::create();
        $client = new Client();

        return $client->request('GET', $url, ['verify' => false, 'headers' => [
            'User-Agent' => $faker->userAgent
        ]]);
    }

    /**
     * @param string $url
     * @return DOMXPath
     * @throws GuzzleException
     */
    protected function requestXpath(string $url): DOMXPath {
        $doc = new DOMDocument();

        libxml_use_internal_errors(true);

        $doc->loadHTML($this->request($url)->getBody());

        return new DOMXPath($doc);
    }
}
