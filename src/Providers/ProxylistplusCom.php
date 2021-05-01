<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class ProxylistplusCom extends Provider implements ProviderInterface {
    const URL = 'https://list.proxylistplus.com/Fresh-HTTP-Proxy-List-1';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return $this->parse(self::URL, 'table.bg > tr.cells')->each(function(Crawler $node) {
            $proxy  = new Proxy();
            $tds    = $node->filter('td');

            $proxy->setIp($tds->eq(1)->text());
            $proxy->setPort($tds->eq(2)->text());
            $proxy->setType($tds->eq(3)->text());
            $proxy->setCountry($tds->eq(4)->text());

            return $proxy;
        });
    }
}
