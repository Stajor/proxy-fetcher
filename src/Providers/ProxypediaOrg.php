<?php namespace ProxyFetcher\Providers;

use DOMElement;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class ProxypediaOrg extends Provider implements ProviderInterface {
    const URL = 'https://proxypedia.org';

    public function fetch(): array {
        return array_filter($this->parse(self::URL, 'ul > li')->each(function(Crawler $node) {
            $a = $node->filter('a');

            if ($a->count() == 0 || strpos($a->first()->text(), ':') === false) {
                return null;
            }

            list($ip, $port) = explode(':', $a->first()->text());

            $country = str_replace([$a->first()->text(), '(', ')'], [''], $node->text());

            $proxy  = new Proxy();
            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setCountry(empty($country) ? 'N/A' : $country);
            $proxy->setType('http');

            return $proxy;
        }));
    }
}
