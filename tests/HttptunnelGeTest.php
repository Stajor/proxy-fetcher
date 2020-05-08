<?php

class HttptunnelGeTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('httptunnel.ge');
    }
}
