<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class ProxyListOrg extends Provider implements ProviderInterface {
    const URL = 'https://proxy-list.org/english/index.php';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//div[@class="table-wrap"]//div[@class="table"]//ul') AS $node) {
            $proxy  = new Proxy();
            $lis    = $node->getElementsByTagName('li');
            $uri    = base64_decode(str_replace(["Proxy('", "')"], '', $lis->item(0)->textContent));
            list($ip, $port) = explode(':', $uri);

            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setCountry($lis->item(4)->textContent);
            $proxy->setHttps($lis->item(1)->textContent == 'HTTPS');
            $proxy->setType($lis->item(3)->textContent);

            $data[] = $proxy;
        }

        return $data;
    }
}
