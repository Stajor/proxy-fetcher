<?php namespace ProxyFetcher;

use Exception;
use ProxyFetcher\Providers\FreeProxyListNet;
use ProxyFetcher\Providers\HideMyIpCom;
use ProxyFetcher\Providers\HidesterCom;
use ProxyFetcher\Providers\HttptunnelGe;
use ProxyFetcher\Providers\MtproXyz;
use ProxyFetcher\Providers\ProviderInterface;
use ProxyFetcher\Providers\ProxyDailyCom;
use ProxyFetcher\Providers\ProxydbNet;
use ProxyFetcher\Providers\ProxyListDownload;
use ProxyFetcher\Providers\ProxyListOrg;
use ProxyFetcher\Providers\ProxypediaOrg;
use ProxyFetcher\Providers\ProxyscanIo;
use ProxyFetcher\Providers\SslproxiesOrg;
use ProxyFetcher\Providers\XroxyCom;

class Manager {
    protected $providers = [
        'free-proxy-list.net'   => FreeProxyListNet::class,
        'sslproxies.org'        => SslproxiesOrg::class,
        'mtpro.xyz'             => MtproXyz::class,
        'xroxy.com'             => XroxyCom::class,
        'proxy-list.org'        => ProxyListOrg::class,
        'httptunnel.ge'         => HttptunnelGe::class,
        'proxydb.net'           => ProxydbNet::class,
        'proxy-list.download'   => ProxyListDownload::class,
        'hide-my-ip.com'        => HideMyIpCom::class,
        'proxy-daily.com'       => ProxyDailyCom::class,
        'proxypedia.org'        => ProxypediaOrg::class,
        'proxyscan.io'          => ProxyscanIo::class,
        'hidester.com'          => HidesterCom::class
    ];

    /**
     * Get proxies list
     * @param array $filters
     * @return array
     */
    public function fetch(array $filters = []): array {
        $proxies = [];

        foreach ($this->providers AS $host => $class) {
            if (isset($filters['provider']) && $filters['provider'] != $host) {
                continue;
            }

            try {
                $provider   = $this->getProvider($host);
                $data       = $provider->fetch();
            } catch (Exception $e) {
                continue;
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

    /**
     * @param string $providerHost
     * @return ProviderInterface
     */
    public function getProvider(string $providerHost): ProviderInterface {
        $class = $this->providers[$providerHost];

        return new $class();
    }

    /**
     * @param string $name
     * @param ProviderInterface $provider
     */
    public function addProvider(string $name, ProviderInterface $provider) {
        $this->providers[$name] = get_class($provider);
    }
}
