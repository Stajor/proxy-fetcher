<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;

class ProxypediaOrg extends Provider implements ProviderInterface {
    const URL = 'https://proxypedia.org';

    public function fetch(): array {
        $data   = [];
        $xpath  = $this->requestXpath(self::URL);

        /** @var DOMElement $node */
        foreach ($xpath->query('//ul/li') AS $node) {
            $a = $node->getElementsByTagName('a');

            if ($a->count() == 0 || strpos($a->item(0)->textContent, ':') === false) {
                continue;
            }

            list($ip, $port) = explode(':', $a->item(0)->textContent);

            $country = str_replace([$a->item(0)->textContent, '(', ')'], [''], $node->textContent);

            $proxy  = new Proxy();
            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setCountry(empty($country) ? 'N/A' : $country);
            $proxy->setHttps(false);
            $proxy->setType('http');

            $data[] = $proxy;
        }

        return $data;
    }
}
