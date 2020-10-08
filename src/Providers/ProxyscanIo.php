<?php namespace ProxyFetcher\Providers;

use ProxyFetcher\Proxy;

class ProxyscanIo extends Provider implements ProviderInterface {
    const URL = 'https://www.proxyscan.io/api/proxy?limit=20';

    public function fetch(): array {
        $data = [];

        foreach (json_decode($this->request(self::URL)->getBody(), true) AS $row) {
            $proxy = new Proxy();
            $proxy->setIp($row['Ip']);
            $proxy->setPort($row['Port']);
            $proxy->setCountry($row['Location']['countryCode']);
            $proxy->setHttps(false);
            $proxy->setType($row['Type'][0]);

            $data[] = $proxy;
        }

        return $data;
    }
}
