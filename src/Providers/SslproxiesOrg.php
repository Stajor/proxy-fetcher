<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class SslproxiesOrg extends Provider implements ProviderInterface {
    const URL = 'https://www.sslproxies.org';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return $this->parse(self::URL, '#proxylisttable > tbody > tr')->each(function(Crawler $node) {
            $proxy  = new Proxy();
            $tds    = $node->filter('td');

            $proxy->setIp($tds->eq(0)->text());
            $proxy->setPort($tds->eq(1)->text());
            $proxy->setCountry($tds->eq(2)->text());
            $proxy->setType($tds->eq(4)->text());

            return $proxy;
        });
    }
}
