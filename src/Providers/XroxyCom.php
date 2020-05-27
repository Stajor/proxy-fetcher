<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class XroxyCom extends Provider implements ProviderInterface {
    const URL = 'https://madison.xroxy.com/proxylist.php?port=&type=All_http&ssl=&country=&latency=&reliability=#table';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//tr[@class="row1" or @class="row0"]') AS $node) {
            $proxy  = new Proxy();
            $tds    = $node->getElementsByTagName('td');

            $proxy->setIp($tds->item(0)->textContent);
            $proxy->setPort($tds->item(1)->textContent);
            $proxy->setCountry($tds->item(4)->textContent);
            $proxy->setHttps($tds->item(3)->textContent == 'true');
            $proxy->setType($tds->item(2)->textContent);

            $data[] = $proxy;
        }

        return $data;
    }
}
