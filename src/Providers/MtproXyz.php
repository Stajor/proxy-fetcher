<?php namespace ProxyFetcher\Providers;

use GuzzleHttp\Client;

class MtproXyz {
    const URL = 'https://mtpro.xyz/api/?type=http';

    public function fetch() {
        $client     = new Client();
        $results    = [];
        $response   = $client->request('GET', self::URL);

        foreach (json_decode($response->getBody(), true) AS $row) {
            $results[] = [
                'ip'            => $row['ip'],
                'port'          => $row['port'],
                'country_code'  => $row['country'],
                'https'         => true
            ];
        }

        return $results;
    }
}
