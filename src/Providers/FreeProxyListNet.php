<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Client;

class FreeProxyListNet {
    const URL = 'https://free-proxy-list.net/';

    public function fetch() {
        $client     = new Client();
        $doc        = new \DOMDocument();
        $results    = [];

        libxml_use_internal_errors(true);

        $response = $client->request('GET', self::URL);
        $doc->loadHTML($response->getBody());

        $xpath = new \DOMXPath($doc);

        /** @var \DOMElement $node */
        foreach ($xpath->query('//table[@id="proxylisttable"]//tbody//tr') AS $i => $node) {
            $tds = $node->getElementsByTagName('td');

            $results[] = [
                'ip'            => $tds->item(0)->textContent,
                'port'          => $tds->item(1)->textContent,
                'country_code'  => strtolower($tds->item(2)->textContent),
                'https'         => $tds->item(6)->textContent == 'yes'
            ];
        }

        return $results;
    }
}
