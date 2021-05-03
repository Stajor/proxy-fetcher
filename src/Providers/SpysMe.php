<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;

class SpysMe extends Provider implements ProviderInterface {
    const URL = 'https://spys.me/proxy.txt';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        $lines = explode("\n", $this->request(self::URL)->getBody());

        return array_filter(array_map(function(string $row) {
            $ex = explode(' ', $row);

            if (empty($ex) || substr_count($ex[0], '.') < 3) {
                return null;
            }

            list($ip, $port) = explode(':', $ex[0]);

            $proxy = new Proxy();
            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setCountry($ex[1]);
            $proxy->setType($ex[2] == '+' ? 'https' : 'http');

            return $proxy;
        }, $lines), function($proxy) { return !is_null($proxy); });
    }
}
