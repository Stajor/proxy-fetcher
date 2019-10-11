<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class GatherproxyCom extends Provider implements ProviderInterface {
    const URL = 'http://www.gatherproxy.com';

    public function fetch(): array {
        return array_merge($this->fetchMain(), $this->fetchSocks());
    }

    private function fetchMain() {
        $xpath  = $this->requestXpath(self::URL);
        $data   = [];

        /** @var DOMElement $node */
        foreach ($xpath->query('//div[@class="proxy-list"]//table//script') AS $node) {
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

    private function fetchSocks() {
        $xpath  = $this->requestXpath(self::URL.'/sockslist');
        $data   = [];

        /** @var DOMElement $node */
        foreach ($xpath->query('//table[@id="tblproxy"]//tr') AS $i => $node) {
            if ($i < 2) {
                continue;
            }

            $proxy  = new Proxy();
            $tds    = $node->getElementsByTagName('td');

            $proxy->setIp(str_replace(["document.write('", "')"], ['', ''], $tds->item(1)->textContent));
            $proxy->setPort(str_replace(["document.write('", "')"], ['', ''], $tds->item(2)->textContent));
            $proxy->setCountry($tds->item(3)->textContent);
            $proxy->setHttps(true);
            $proxy->setType($tds->item(5)->textContent);

            $data[] = $proxy;
        }

        return $data;
    }
}
