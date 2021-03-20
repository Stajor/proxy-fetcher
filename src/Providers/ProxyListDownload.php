<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class ProxyListDownload extends Provider implements ProviderInterface {
    const URL = 'https://www.proxy-list.download/';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        $types  = ['HTTP', 'HTTPS', 'SOCKS4', 'SOCKS5'];
        $data   = [];

        foreach ($types AS $type) {
            $this->parse(self::URL.$type, '#tabli > tr')->each(function(Crawler $node) use (&$data) {
                $tds = $node->filter('td');

                $proxy  = new Proxy();
                $proxy->setIp($tds->eq(0)->text());
                $proxy->setPort($tds->eq(1)->text());
                $proxy->setType($tds->eq(2)->text());
                $proxy->setCountry($tds->eq(3)->text());

                $data[] = $proxy;
            });

            sleep(2);
        }

        return $data;
    }
}
