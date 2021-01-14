<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class ProxydbNet extends Provider implements ProviderInterface {
    const URL = 'http://proxydb.net';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return $this->parse(self::URL, 'table > tbody > tr')->each(function(Crawler $node) {
            $proxy  = new Proxy();
            $tds    = $node->filter('td');
            list($ip, $port) = explode(':', $tds->first()->text());

            $proxy->setIp($ip);
            $proxy->setPort((int)$port);
            $proxy->setCountry($tds->eq(2)->text());
            $proxy->setType($tds->eq(4)->text());

            return $proxy;
        });
    }
}
