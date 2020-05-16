<?php

class ProxyListDownloadTest extends ProviderTestCase {
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        self::setProvider('proxy-list.download');
    }
}
