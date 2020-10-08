<?php

class ProxyscanIoTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('proxyscan.io');
    }
}
