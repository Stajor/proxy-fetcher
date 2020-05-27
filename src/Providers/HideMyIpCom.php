<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class HideMyIpCom extends Provider implements ProviderInterface {
    const URL = 'https://www.hide-my-ip.com/proxylist.shtml';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//script') AS $node) {
            if (strpos($node->textContent, 'var json') !== false) {
                list($json,) = explode(';', str_replace('var json =', '', $node->textContent));

                foreach (json_decode(trim($json), true) AS $row) {
                    $proxy  = new Proxy();
                    $proxy->setIp($row['i']);
                    $proxy->setPort($row['p']);
                    $proxy->setCountry($row['c']['f']);
                    $proxy->setHttps($row['tp'] === 'HTTPS');
                    $proxy->setType($row['tp']);

                    $data[] = $proxy;
                }
            }
        }

        return $data;
    }
}
