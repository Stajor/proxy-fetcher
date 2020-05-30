<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class ProxyDailyCom extends Provider implements ProviderInterface {
    const URL = 'https://proxy-daily.com/';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);
        $type   = null;

        /** @var DOMElement $node */
        foreach ($xpath->query('//div[starts-with(@class, "centeredProxyList")]') AS $node) {
            if (is_null($type)) {
                if (strpos($node->textContent, 'Socks4') !== false) {
                    $type = 'Socks4';
                } elseif (strpos($node->textContent, 'Socks5') !== false) {
                    $type = 'Socks5';
                } else {
                    $type = 'Http';
                }

                continue;
            }

            $rows = explode("\n", trim($node->textContent));

            foreach ($rows AS $row) {
                $proxy  = new Proxy();
                list($ip, $port) = explode(':', $row);

                $proxy->setIp($ip);
                $proxy->setPort($port);
                $proxy->setCountry('N/A');
                $proxy->setHttps(false);
                $proxy->setType($type);

                $data[] = $proxy;
            }


            $type = null;


        }

        return $data;
    }
}
