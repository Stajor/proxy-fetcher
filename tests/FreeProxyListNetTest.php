<?php

class FreeProxyListNetTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('free-proxy-list.net');
    }
}
