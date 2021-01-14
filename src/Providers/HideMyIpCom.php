<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Exception\GuzzleException;
use ProxyFetcher\Proxy;
use Symfony\Component\DomCrawler\Crawler;

class HideMyIpCom extends Provider implements ProviderInterface {
    const URL = 'https://www.hide-my-ip.com/proxylist.shtml';

    /**
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array {
        $data = [];

        $this->parse(self::URL, 'script')->each(function(Crawler $node) use (&$data) {
            if (strpos($node->text(), 'var json') !== false) {
                list($json,) = explode(';', str_replace('var json =', '', $node->text()));

                foreach (json_decode(trim($json), true) AS $row) {
                    $proxy  = new Proxy();
                    $proxy->setIp($row['i']);
                    $proxy->setPort($row['p']);
                    $proxy->setCountry($row['c']['f']);
                    $proxy->setType($row['tp']);

                    $data[] = $proxy;
                }
            }
        });

        return $data;
    }
}
