<?php

class ProxylistplusComTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('proxylistplus.com');
    }
}
