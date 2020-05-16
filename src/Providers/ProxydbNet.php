<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class ProxydbNet extends Provider implements ProviderInterface {
    const URL = 'http://proxydb.net';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//table//tbody//tr') AS $node) {
            $proxy  = new Proxy();
            $tds    = $node->getElementsByTagName('td');
            list($ip, $port) = explode(':', $tds->item(0)->textContent);

            $proxy->setIp($ip);
            $proxy->setPort((int)$port);
            $proxy->setCountry($tds->item(2)->textContent);
            $proxy->setHttps($tds->item(6)->textContent == 'HTTPS');
            $proxy->setType($tds->item(4)->textContent);

            $data[] = $proxy;
        }

        return $data;
    }
}
