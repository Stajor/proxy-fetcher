<?php namespace ProxyFetcher;

use ProxyFetcher\Providers\FreeProxyListNet;

class Manager {
    protected $providers = [
        'free-proxy-list.net' => FreeProxyListNet::class
    ];

    public function fetch() {
        $provider = new FreeProxyListNet();

        return $provider->fetch();
    }
}
