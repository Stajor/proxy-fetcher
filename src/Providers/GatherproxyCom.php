<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class GatherproxyCom extends Provider implements ProviderInterface {
    const URL = 'http://www.gatherproxy.com';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//div[@class="proxy-list"]/table/script') AS $node) {
            $proxy  = new Proxy();
            $json   = json_decode(str_replace(['gp.insertPrx(', ');'], ['', ''], trim($node->textContent)), true);

            $proxy->setIp($json['PROXY_IP']);
            $proxy->setPort(intval($json['PROXY_PORT'], 16));
            $proxy->setCountry($json['PROXY_COUNTRY']);
            $proxy->setHttps(true);
            $proxy->setType($json['PROXY_TYPE']);

            $data[] = $proxy;
        }

        return $data;
    }
}
