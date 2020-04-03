<?php namespace ProxyFetcher\Providers;

use ProxyFetcher\Proxy;

class HttptunnelGe extends Provider implements ProviderInterface {
    const URL = 'http://www.httptunnel.ge/ProxyListForFree.aspx';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//table[contains(@id, "GridView")]//tr[(count(td)>2)]') AS $node) {
            $proxy  = new Proxy();
            $tds    = $node->getElementsByTagName('td');

            list($ip, $port) = explode(':', trim($tds->item(0)->textContent));

            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setCountry($tds->item(7)->getElementsByTagName('img')->item(0)->getAttribute('title'));
            $proxy->setHttps(false);
            $proxy->setType($tds->item(4)->textContent);

            $data[] = $proxy;
        }

        return $data;
    }
}
