<?php

class SocksProxyNetTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('socks-proxy.net');
    }
}
