<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class XroxyCom extends Provider implements ProviderInterface {
    const URL = 'https://www.xroxy.com/proxylist.htm';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return $this->parse(self::URL, 'tr.row1, tr.row0')->each(function(Crawler $node) {
            $proxy  = new Proxy();
            $tds    = $node->filter('td');

            $proxy->setIp($tds->eq(0)->text());
            $proxy->setPort($tds->eq(1)->text());
            $proxy->setCountry($tds->eq(4)->text());
            $proxy->setType($tds->eq(2)->text());

            return $proxy;
        });
    }
}
