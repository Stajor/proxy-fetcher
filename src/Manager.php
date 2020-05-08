<?php namespace ProxyFetcher;

use Exception;
use ProxyFetcher\Providers\FreeProxyListNet;
use ProxyFetcher\Providers\GatherproxyCom;
use ProxyFetcher\Providers\HttptunnelGe;
use ProxyFetcher\Providers\MtproXyz;
use ProxyFetcher\Providers\ProviderInterface;
use ProxyFetcher\Providers\ProxyListOrg;
use ProxyFetcher\Providers\SslproxiesOrg;
use ProxyFetcher\Providers\XroxyCom;

class Manager {
    protected $providers = [
        'free-proxy-list.net'   => FreeProxyListNet::class,
        'sslproxies.org'        => SslproxiesOrg::class,
        'gatherproxy.com'       => GatherproxyCom::class,
        'mtpro.xyz'             => MtproXyz::class,
        'xroxy.com'             => XroxyCom::class,
        'proxy-list.org'        => ProxyListOrg::class,
        'httptunnel.ge'         => HttptunnelGe::class
    ];

    /**
     * Get proxies list
     * @param array $filters
     * @return array
     */
    public function fetch(array $filters = []): array {
        $proxies = [];

        foreach ($this->providers AS $host => $class) {
            $data = [];

            if (isset($filters['provider']) && $filters['provider'] != $host) {
                continue;
            }

            try {
                $provider   = $this->getProvider($host);
                $data       = $provider->fetch();
            } catch (Exception $e) {
//                echo $e->getMessage();
            }

            // Filter rows
            foreach ($filters AS $filter => $value) {
                $getter = 'get'.ucfirst($filter);

                if (method_exists(Proxy::class, $getter)) {
                    $data = array_filter($data, function(Proxy $proxy) use ($getter, $value) {
                        return $proxy->{$getter}() == $value;
                    });
                }
            }

            $proxies = array_merge($proxies, $data);

            // Limit rows
            if (isset($filters['limit']) && count($proxies) >= $filters['limit']) {
                $proxies = array_slice($proxies, 0, $filters['limit']);
                break;
            }
        }

        return $proxies;
    }

    /**
     * Get providers list
     * @return array
     */
    public function getProviders(): array {
        return $this->providers;
    }

    public function getProvider(string $providerHost): ProviderInterface {
        $class = $this->providers[$providerHost];

        return new $class();
    }
}
