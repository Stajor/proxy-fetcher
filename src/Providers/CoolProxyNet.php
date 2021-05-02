<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;

class CoolProxyNet extends Provider implements ProviderInterface {
    const URL = 'https://cool-proxy.net/proxies.json';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return array_map(function(array $row) {
            $proxy = new Proxy();
            $proxy->setIp($row['ip']);
            $proxy->setPort($row['port']);
            $proxy->setCountry($row['country_name']);
            $proxy->setType($row['anonymous'] ? 'https' : 'http');

            return $proxy;
        }, json_decode($this->request(self::URL)->getBody(), true));
    }
}
