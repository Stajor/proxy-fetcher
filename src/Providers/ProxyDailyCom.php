<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class ProxyDailyCom extends Provider implements ProviderInterface {
    const URL = 'https://proxy-daily.com/';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        $data = [];

        $this->parse(self::URL, '.freeProxyStyle')->each(function(Crawler $node) use (&$data) {
            $title = $node->previousAll()->eq(1)->text();

            if (strpos($title, 'Socks4') !== false) {
                $type = 'Socks4';
            } elseif (strpos($title, 'Socks5') !== false) {
                $type = 'Socks5';
            } else {
                $type = 'Http';
            }

            foreach (explode(' ', trim($node->text())) AS $row) {
                $proxy  = new Proxy();
                list($ip, $port) = explode(':', $row);

                $proxy->setIp($ip);
                $proxy->setPort($port);
                $proxy->setCountry('N/A');
                $proxy->setType($type);

                $data[] = $proxy;
            }
        });

        return $data;
    }
}
