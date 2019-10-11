<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class SpysOne extends Provider implements ProviderInterface {
    const URL = 'http://www.gatherproxy.com';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//table[@width="65%"]//tr') AS $i => $node) {
            if ($i < 2) {
                continue;
            }

            $proxy  = new Proxy();
            $tds    = $node->getElementsByTagName('td');

            die(var_dump($tds->item(0)->getElementsByTagName('font')->item(0)));

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
