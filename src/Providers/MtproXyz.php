<?php namespace ProxyFetcher\Providers;

use ProxyFetcher\Proxy;

class MtproXyz extends Provider implements ProviderInterface {
    const URL = 'https://mtpro.xyz/api/?type=socks';

    public function fetch(): array {
        $data   = [];
        $rows   = json_decode($this->request(self::URL)->getBody(), true) ?? [];

        foreach ($rows AS $row) {
            $proxy  = new Proxy();
            $proxy->setIp($row['ip']);
            $proxy->setPort($row['port']);
            $proxy->setCountry($row['country']);
            $proxy->setHttps(true);
            $proxy->setType('SOCKS5');

            $data[] = $proxy;
        }

        return $data;
    }
}
