<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class HttptunnelGe extends Provider implements ProviderInterface {
    const URL = 'http://www.httptunnel.ge/ProxyListForFree.aspx';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return array_filter($this->parse(self::URL, '#ctl00_ContentPlaceHolder1_GridViewNEW > tr')
            ->each(function(Crawler $node) {
                $tds = $node->filter('td');

                if (!$tds->count()) {
                    return null;
                }

                $proxy = new Proxy();

                list($ip, $port) = explode(':', trim($tds->first()->text()));

                $proxy->setIp($ip);
                $proxy->setPort((int)$port);
                $proxy->setCountry($tds->eq(7)->filter('img')->first()->attr('title'));
                $proxy->setType($tds->eq(4)->text());

                return $proxy;
            }));
    }
}
