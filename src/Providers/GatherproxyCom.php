<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Client;

class GatherproxyCom {
    const URL = 'http://www.gatherproxy.com';

    public function fetch() {
        $client     = new Client();
        $doc        = new \DOMDocument();
        $results    = [];

        libxml_use_internal_errors(true);

        $response = $client->request('GET', self::URL);
        $doc->loadHTML($response->getBody());

        $xpath = new \DOMXPath($doc);

        /** @var \DOMElement $node */
        foreach ($xpath->query('//div[@class="proxy-list"]/table/script') AS $node) {
            $data = json_decode(str_replace(['gp.insertPrx(', ');'], ['', ''], trim($node->textContent)), true);

            $results[] = [
                'ip'            => $data['PROXY_IP'],
                'port'          => intval($data['PROXY_PORT'], 16),
                'country_code'  => $data['PROXY_COUNTRY'],
                'https'         => true
            ];
        }

        return $results;
    }
}
