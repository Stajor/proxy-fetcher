<?php

class ProxyDailyComTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('proxy-daily.com');
    }
}
