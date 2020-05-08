<?php

class SslproxiesOrgTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('sslproxies.org');
    }
}
