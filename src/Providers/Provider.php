<?php namespace ProxyFetcher\Providers;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class Provider {
    protected function request(string $url): ResponseInterface {
        $client     = new Client();
        $response   = $client->request('GET', $url);

        return $response;
    }

    protected function requestXpath(string $url): DOMXPath {
        $doc = new DOMDocument();

        libxml_use_internal_errors(true);

        $doc->loadHTML($this->request($url)->getBody());

        return new DOMXPath($doc);
    }
}
