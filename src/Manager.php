<?php namespace ProxyFetcher;

use ProxyFetcher\Providers\FreeProxyListNet;
use ProxyFetcher\Providers\GatherproxyCom;
use ProxyFetcher\Providers\SslproxiesOrg;

class Manager {
    protected $providers = [
        'free-proxy-list.net'   => FreeProxyListNet::class,
        'sslproxies.org'        => SslproxiesOrg::class,
        'gatherproxy.com'       => GatherproxyCom::class
    ];

    public function fetch() {
        $proxies = [];

        foreach ($this->providers AS $provider => $class) {
            $provider = new $class();
            $proxies = array_merge($proxies, $provider->fetch());
        }

        return $proxies;
    }
}
