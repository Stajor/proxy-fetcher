<?php namespace ProxyFetcher\Test;

use ProxyFetcher\Providers\ProviderInterface;
use ProxyFetcher\Proxy;

class CustomProvider implements ProviderInterface {
    public function fetch(): array {
        $proxy = new Proxy();
        $proxy->setIp('127.0.0.1');
        $proxy->setPort(8080);
        $proxy->setCountry('N/A');
        $proxy->setType('HTTP');

        return [$proxy];
    }
}
