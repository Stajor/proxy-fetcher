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
     * @param array $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function request(string $url, array $headers = []): ResponseInterface {
        $faker  = Factory::create();
        $client = new Client();

        $headers['User-Agent'] = $faker->userAgent;

        return $client->request('GET', $url, ['verify' => false, 'headers' => $headers]);
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

    /**
     * @param string $url
     * @param array $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function requestAjax(string $url, array $headers = []): ResponseInterface {
        return $this->request($url, array_merge(['Content-Type' => 'application/json'], $headers));
    }
}
