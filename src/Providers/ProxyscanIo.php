<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;

class ProxyscanIo extends Provider implements ProviderInterface {
    const URL = 'https://www.proxyscan.io/api/proxy?limit=20';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return array_map(function(array $row) {
            $proxy = new Proxy();
            $proxy->setIp($row['Ip']);
            $proxy->setPort($row['Port']);
            $proxy->setCountry($row['Location']['countryCode']);
            $proxy->setType($row['Type'][0]);

            return $proxy;
        }, json_decode($this->request(self::URL)->getBody(), true));
    }
}
