<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;

class MtproXyz extends Provider implements ProviderInterface {
    const URL = 'https://mtpro.xyz/api/?type=socks';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return array_map(function(array $row) {
            $proxy = new Proxy();
            $proxy->setIp($row['ip']);
            $proxy->setPort($row['port']);
            $proxy->setCountry($row['country']);
            $proxy->setType('SOCKS5');

            return $proxy;
        }, json_decode($this->request(self::URL)->getBody(), true) ?? []);
    }
}
