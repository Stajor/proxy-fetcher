<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class FreeProxyListNet extends Provider implements ProviderInterface {
    const URL = 'https://free-proxy-list.net/';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//table[@id="proxylisttable"]//tbody//tr') AS $node) {
            $proxy  = new Proxy();
            $tds    = $node->getElementsByTagName('td');

            $proxy->setIp($tds->item(0)->textContent);
            $proxy->setPort($tds->item(1)->textContent);
            $proxy->setCountry($tds->item(2)->textContent);
            $proxy->setHttps($tds->item(6)->textContent == 'yes');
            $proxy->setType($tds->item(4)->textContent);

            $data[] = $proxy;
        }

        return $data;
    }
}
