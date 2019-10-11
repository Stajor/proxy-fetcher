<?php namespace ProxyFetcher\Providers;

use ProxyFetcher\Proxy;

class ProxyrackCom extends Provider implements ProviderInterface {
    const URL = 'https://www.proxyrack.com/proxyfinder/proxies.json?page=1&perPage=50&offset=0';

    public function fetch(): array {
        $rows   = json_decode($this->requestByPass(self::URL), true);
        $data   = [];

        foreach ($rows['records'] AS $row) {
            $proxy = new Proxy();
            $proxy->setIp($row['ip']);
            $proxy->setPort($row['port']);
            $proxy->setCountry($row['country']);
            $proxy->setHttps(true);
            $proxy->setType($row['protocol']);

            $data[] = $proxy;
        }

        return $data;
    }
}
