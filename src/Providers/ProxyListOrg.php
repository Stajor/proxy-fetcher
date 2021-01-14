<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class ProxyListOrg extends Provider implements ProviderInterface {
    const URL = 'https://proxy-list.org/english/index.php';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        return $this->parse(self::URL, '.table > ul')->each(function(Crawler $node) {
            $proxy  = new Proxy();
            $lis    = $node->filter('li');
            $uri    = base64_decode(str_replace(["Proxy('", "')"], '', $lis->first()->text()));

            list($ip, $port) = explode(':', $uri);

            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setCountry($lis->eq(4)->text());
            $proxy->setType($lis->eq(3)->text());

            return $proxy;
        });
    }
}
