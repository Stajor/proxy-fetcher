<?php

class CoolProxyNetTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('cool-proxy.net');
    }
}
