<?php

use PHPUnit\Framework\TestCase;
use ProxyFetcher\Manager;
use ProxyFetcher\Providers\ProviderInterface;

class ProviderTestCase extends TestCase {
    private static $provider;

    public function testData() {
        /** @var Proxy $proxy */
        foreach (self::getProvider()->fetch() AS $proxy) {
            $this->assertNotEmpty($proxy->getIp());
            $this->assertNotEmpty($proxy->getPort());
            $this->assertNotEmpty($proxy->getCountry());
            $this->assertIsBool($proxy->getHttps());
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
