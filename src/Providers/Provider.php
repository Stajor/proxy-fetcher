<?php namespace ProxyFetcher\Providers;

use CloudflareBypass\CFCurlImpl;
use CloudflareBypass\Model\UAMOptions;
use DOMDocument;
use DOMXPath;
use Faker\Factory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

abstract class Provider {
    protected function request(string $url): ResponseInterface {
        $faker      = Factory::create();
        $client     = new Client();
        $response   = $client->request('GET', $url, ['verify' => false, 'headers' => [
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

    protected function requestByPass(string $url) {
        $faker  = Factory::create();
        $ch     = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Upgrade-Insecure-Requests: 1",
            'User-Agent: '.$faker->userAgent,
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3",
            "Accept-Language: en-US,en;q=0.9"
        ]);

        $cfCurl     = new CFCurlImpl();
        $cfOptions  = new UAMOptions();
        $cfOptions->setDelay(5);

        return $cfCurl->exec($ch, $cfOptions);
    }
}
