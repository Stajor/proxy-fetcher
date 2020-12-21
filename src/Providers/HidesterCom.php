<?php namespace ProxyFetcher\Providers;

use ProxyFetcher\Proxy;

class HidesterCom extends Provider implements ProviderInterface {
    const URL = 'https://hidester.com/proxydata/php/data.php';

    public function fetch(): array {
        $data   = [];
        $params = [
            'mykey' => 'data',
            'offset' => '0',
            'limit' => '50',
            'orderBy' => 'latest_check',
            'sortOrder' => 'DESC',
            'country' => '',
            'port' => '',
            'type' => '15',
            'anonymity' =>  '7',
            'ping' => '7',
            'gproxy' => '2'
        ];
        $response = $this->requestAjax(self::URL.'?'.http_build_query($params), [
            'referer' => 'https://hidester.com/proxylist/'
        ]);

        foreach (json_decode($response->getBody(), true) ?? [] AS $row) {
            $proxy  = new Proxy();
            $proxy->setIp($row['IP']);
            $proxy->setPort($row['PORT']);
            $proxy->setCountry($row['country']);
            $proxy->setHttps(true);
            $proxy->setType($row['type']);

            $data[] = $proxy;
        }

        return $data;
    }
}
