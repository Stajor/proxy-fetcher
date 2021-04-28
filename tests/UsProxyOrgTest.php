<?php

class UsProxyOrgTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('us-proxy.org');
    }
}
