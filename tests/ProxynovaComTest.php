<?php

class ProxynovaComTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('proxynova.com');
    }
}
