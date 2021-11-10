<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class ProxynovaCom extends Provider implements ProviderInterface {
    const URL = 'https://www.proxynova.com/proxy-server-list';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return array_filter($this->parse(self::URL, '#tbl_proxy_list > tbody > tr')->each(function(Crawler $node) {
            $tds = $node->filter('td');

            if ($tds->count() <= 6) {
               return null;
            }

            $ip = ltrim(preg_replace("/[^0-9.]/", "", $tds->first()->text()), '.');

            $proxy = new Proxy();
            $proxy->setIp($ip);
            $proxy->setPort($tds->eq(1)->text());
            $proxy->setCountry($tds->eq(5)->text());
            $proxy->setType($tds->eq(6)->text());

            return $proxy;
        }));
    }
}
