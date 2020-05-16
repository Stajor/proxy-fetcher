<?php namespace ProxyFetcher\Providers;

use Exception;
use ProxyFetcher\Proxy;

class ProxyListDownload extends Provider implements ProviderInterface {
    const URL = 'https://www.proxy-list.download/api/v0/get?l=en&t=';

    public function fetch(): array {
        $types  = ['http', 'https', 'socks4', 'socks5'];
        $data   = [];

        foreach ($types AS $type) {
            try {
                foreach (json_decode($this->request(self::URL.$type)->getBody(), true)[0]['LISTA'] AS $row) {
                    $proxy  = new Proxy();
                    $proxy->setIp($row['IP']);
                    $proxy->setPort($row['PORT']);
                    $proxy->setCountry($row['COUNTRY'] ?? 'N/A');
                    $proxy->setHttps($row['ANON'] == 'Https');
                    $proxy->setType($row['ANON']);

                    $data[] = $proxy;
                }
            } catch(Exception $e) {}

            sleep(2);
        }

        return $data;
    }
}
