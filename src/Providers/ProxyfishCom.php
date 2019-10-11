<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class ProxyfishCom extends Provider implements ProviderInterface {
    const URL = 'https://www.proxyfish.com/proxylist/';

    public function fetch(): array {
        return $this->fetchByType('SOCKS') + $this->fetchByType('HTTPS');
    }

    private function fetchByType(string $type): array {
        $rows   = json_decode($this->request(self::URL.'server_processing.php?limit=500&type='.$type)->getBody(), true);
        $data   = [];

        foreach (json_decode(base64_decode($rows['data'])) AS $row) {
            $proxy  = new Proxy();
            $country = explode('</span>', $row[3]);

            $proxy->setIp($row[1]);
            $proxy->setPort($row[2]);
            $proxy->setCountry(end($country));
            $proxy->setHttps($row[5] != 'HTTP');
            $proxy->setType(in_array($row[5], ['HTTP', 'HTTPS']) ? $row[6] : $row[5]);

            $data[] = $proxy;
        }

        return $data;
    }
}
