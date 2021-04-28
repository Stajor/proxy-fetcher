<?php namespace ProxyFetcher\Providers;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

abstract class Provider {
    /**
     * @param string $url
     * @param array $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function request(string $url, array $headers = []): ResponseInterface {
        $faker  = Factory::create();
        $client = new Client(['cookies' => true, 'allow_redirects' => true, 'verify' => false]);

        $headers['User-Agent'] = $faker->userAgent;

        return $client->request('GET', $url, ['headers' => $headers]);
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

    /**
     * @param string $url
     * @param string $selector
     * @param array $headers
     * @return Crawler
     * @throws GuzzleException
     */
    protected function parse(string $url, string $selector, array $headers = []): Crawler {
        $content = $this->request($url, $headers)->getBody();
        $crawler = new Crawler((string)$content);

        return $crawler->filter($selector);
    }
}
