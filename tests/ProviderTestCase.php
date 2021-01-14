<?php

use PHPUnit\Framework\TestCase;
use ProxyFetcher\Manager;
use ProxyFetcher\Providers\ProviderInterface;
use ProxyFetcher\Proxy;

class ProviderTestCase extends TestCase {
    private static $provider;

    public function testData() {
        $proxies = self::getProvider()->fetch();

        $this->assertNotEmpty($proxies);

        /** @var Proxy $proxy */
        foreach ($proxies AS $proxy) {
            $this->assertNotEmpty($proxy->getIp());
            $this->assertNotEmpty($proxy->getPort());
            $this->assertNotEmpty($proxy->getCountry());
            $this->assertNotEmpty($proxy->getType());
        }
    }

    protected static function setProvider(string $providerHost) {
        self::$provider = (new Manager())->getProvider($providerHost);
    }

    protected static function getProvider(): ProviderInterface {
        return self::$provider;
    }
}
