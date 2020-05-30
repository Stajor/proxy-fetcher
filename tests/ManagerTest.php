<?php namespace ProxyFetcher\Test;

use PHPUnit\Framework\TestCase;
use ProxyFetcher\Manager;
use ProxyFetcher\Proxy;

class ManagerTest extends TestCase {
    private static $manager;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::$manager = new Manager();
    }

    public function testLimit() {
        $proxies = self::$manager->fetch(['limit' => 10]);

        $this->assertCount(10, $proxies);
    }

    public function testFilterByCountry() {
        $proxies = self::$manager->fetch(['country' => 'US', 'limit' => 10]);

        /** @var Proxy $proxy */
        foreach ($proxies AS $proxy) {
            $this->assertEquals('US', $proxy->getCountry());
        }

        $this->assertNotEmpty($proxies);
    }

    public function testFilterByProvider() {
        $proxies = self::$manager->fetch(['provider' => array_keys(self::$manager->getProviders())[0], 'limit' => 10]);

        $this->assertNotEmpty($proxies);
    }

    public function testGetProvider() {
        foreach (self::$manager->getProviders() AS $host => $class) {
            $this->assertEquals($class, get_class(self::$manager->getProvider($host)));
        }
    }

    public function testCustomProvider() {
        $provider = new CustomProvider();
        $proxies = $provider->fetch();

        self::$manager->addProvider('custom', $provider);

        $this->assertInstanceOf(CustomProvider::class, self::$manager->getProvider('custom'));
        $this->assertCount(1, $proxies);
        $this->assertInstanceOf(Proxy::class, $proxies[0]);
    }
}
