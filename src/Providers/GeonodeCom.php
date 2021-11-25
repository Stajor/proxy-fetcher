<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;

class GeonodeCom extends Provider implements ProviderInterface {
    const URL = 'https://proxylist.geonode.com/api/proxy-list?limit=200&page=1&sort_by=lastChecked&sort_type=desc';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        $items = json_decode($this->request(self::URL)->getBody(), true);

        return array_map(function(array $row) {
            $proxy = new Proxy();
            $proxy->setIp($row['ip']);
            $proxy->setPort($row['port']);
            $proxy->setCountry($row['country']);
            $proxy->setType(count($row['protocols']) ? $row['protocols'][0] : 'N/A');

            return $proxy;
        }, $items['data'] ?? []);
    }
}
